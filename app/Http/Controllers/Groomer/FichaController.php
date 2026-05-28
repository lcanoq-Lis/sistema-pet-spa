<?php

namespace App\Http\Controllers\Groomer;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\ChecklistItemCatalogo;
use App\Models\FichaChecklist;
use App\Models\FichaGrooming;
use App\Models\FotoGrooming;
use App\Models\Groomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\NotificacionController;

class FichaController extends Controller
{
    public function create($citaId)
    {
        $groomer = Groomer::where('usuario_id', Auth::id())->first();
        $cita    = Cita::where('groomer_id', $groomer->id)
                       ->with(['mascota', 'servicio'])
                       ->findOrFail($citaId);

        // Si ya tiene ficha redirigir a editar
        $ficha = FichaGrooming::where('cita_id', $citaId)->first();
        if ($ficha) {
            return redirect()->route('groomer.ficha.edit', $ficha->id);
        }

        $items = ChecklistItemCatalogo::where('activo', true)->orderBy('orden')->get();

        return view('groomer.ficha.create', compact('cita', 'items'));
    }

    public function store(Request $request)
    {
        // Verificar si ya existe ficha
        $fichaExistente = FichaGrooming::where('cita_id', $request->cita_id)->first();
        if ($fichaExistente) {
            return redirect()->route('groomer.ficha.edit', $fichaExistente->id);
        }

        $request->validate([
            'cita_id'        => 'required|exists:citas,id',
            'estado_inicial' => 'required|string|max:500',
        ]);

        $ficha = FichaGrooming::create([
            'cita_id'        => $request->cita_id,
            'estado_inicial' => $request->estado_inicial,
        ]);

        // Clonar catálogo de checklist vigente a la nueva ficha
        $items = ChecklistItemCatalogo::where('activo', true)->get();
        foreach ($items as $item) {
            FichaChecklist::create([
                'ficha_id'   => $ficha->id,
                'item_id'    => $item->id,
                'completado' => false,
            ]);
        }

        return redirect()->route('groomer.ficha.edit', $ficha->id)->with('status', 'Ficha iniciada correctamente.');
    }

    public function edit($id)
    {
        $ficha = FichaGrooming::with(['cita.mascota', 'cita.servicio', 'checklist.item', 'fotos', 'insumos.producto'])
                              ->findOrFail($id);
        
        $productos = \App\Models\Producto::orderBy('nombre')->get();

        return view('groomer.ficha.edit', compact('ficha', 'productos'));
    }

    /**
     * CORREGIDO: Se añadió protección contra nulos si desmarcan todas las opciones en Blade.
     */
    public function update(Request $request, $id)
    {
         $ficha = FichaGrooming::with('checklist')->findOrFail($id);

    // Advertir si el checklist no está completo
    $checklistData = $request->input('checklist', []);
    $sinCompletar = $ficha->checklist->filter(function($check) use ($checklistData) {
        return !isset($checklistData[$check->item_id]['completado']);
    })->count();

    // Guardar igual pero mostrar advertencia
    $ficha->estado_final   = $request->estado_final;
    $ficha->notas_internas = $request->notas_internas;
    $ficha->save();

    foreach ($checklistData as $itemId => $data) {
        FichaChecklist::where('ficha_id', $id)
            ->where('item_id', $itemId)
            ->update([
                'completado'  => isset($data['completado']),
                'observacion' => $data['observacion'] ?? null,
            ]);
    }

    $mensaje = 'Ficha actualizada correctamente.';
    if ($sinCompletar > 0) {
        $mensaje = "⚠️ Ficha guardada pero tienes {$sinCompletar} ítem(s) del checklist sin completar. No podrás cerrar la ficha hasta completarlos.";
    }

    return redirect()->route('groomer.ficha.edit', $id)->with('status', $mensaje);

    
            $ficha = FichaGrooming::findOrFail($id);

            $ficha->estado_final   = $request->estado_final;
            $ficha->notas_internas = $request->notas_internas;
            $ficha->save();

            // BLINDAJE: Si el usuario desmarca todas las casillas, se asume un array vacío para evitar errores de PHP
            $checklistData = $request->input('checklist', []);

            foreach ($checklistData as $itemId => $data) {
                FichaChecklist::where('ficha_id', $id)
                    ->where('item_id', $itemId)
                    ->update([
                        'completado'  => isset($data['completado']),
                        'observacion' => $data['observacion'] ?? null,
                    ]);
            }

            return redirect()->route('groomer.ficha.edit', $id)->with('status', 'Ficha actualizada correctamente.');
        }

        /**
         * MEJORADO: Inyección automática de NotificacionController para evitar el "new".
         */
        public function cerrar($id, NotificacionController $notificacionService)
        {
            $ficha = FichaGrooming::with('checklist')->findOrFail($id);

        // Verificar que todos los ítems del checklist estén completados
        $sinCompletar = $ficha->checklist->where('completado', false)->count();
        if ($sinCompletar > 0) {
            return back()->withErrors([
                'checklist' => "No puedes cerrar la ficha. Tienes {$sinCompletar} ítem(s) del checklist sin completar."
            ]);
        }

        $ficha->fecha_cierre = now();

        $ficha = FichaGrooming::findOrFail($id);
        $ficha->fecha_cierre = now();
        $ficha->save();

        // Actualizar el estado de la cita asociada
        $cita = Cita::findOrFail($ficha->cita_id);
        $cita->estado = 'completada';
        $cita->save();

        // Notificar al dueño de la mascota
        try {
            // NOTA: Asegúrate de que este método exista dentro de NotificacionController.php
            // Si tiene otro nombre (ej: enviarCorreo), cámbialo aquí abajo:
            $notificacionService->enviarNotificacionFichaCerrada($ficha);
        } catch (\Exception $e) {
            // Logear error si falla la notificación, sin romper el flujo del usuario
            \Illuminate\Support\Facades\Log::error("Error al enviar notificación de cierre de ficha: " . $e->getMessage());
        }

        return redirect()->route('groomer.agenda.index')->with('status', 'Ficha cerrada correctamente. El cliente ha sido notificado.');
    }

    public function agregarFoto(Request $request, $id)
    {
        $request->validate([
            'foto' => 'required|image|max:5120', // máx 5MB
            'tipo' => 'required|in:antes,despues',
        ]);

        $path = $request->file('foto')->store('fichas', 'public');
        $url  = $path;

        FotoGrooming::create([
            'ficha_id' => $id,
            'tipo'     => $request->tipo,
            'url'      => $url,
        ]);

        return back()->with('status', 'Foto agregada correctamente.');
    }

    /**
     * CORREGIDO: Se renombró el parámetro de $fotoId a $id para coincidir con el archivo web.php corregido.
     */
    public function eliminarFoto($id)
    {
        $foto = FotoGrooming::findOrFail($id);
        
        // Eliminar archivo físico del disco público
        \Illuminate\Support\Facades\Storage::disk('public')->delete($foto->url);
        
        $foto->delete();
        
        return back()->with('status', 'Foto eliminada correctamente.');
    }

    public function storeInsumo(Request $request, $fichaId)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad'    => 'required|numeric|min:0.1',
            'unidad'      => 'required|string',
        ]);

        $producto = \App\Models\Producto::findOrFail($request->producto_id);

        // Solo descontar stock si fue usado o desperdiciado
        if ($request->estado !== 'devuelto') {
            $producto->stock = max(0, $producto->stock - $request->cantidad);
            $producto->save();
        }

        \App\Models\InsumoGrooming::create([
            'ficha_id'    => $fichaId,
            'producto_id' => $request->producto_id,
            'cantidad'    => $request->cantidad,
            'unidad'      => $request->unidad,
            'estado'      => $request->estado ?? 'usado',
            'observacion' => $request->observacion,
        ]);
        return back()->with('status', 'Insumo registrado y stock actualizado.');
    }

    public function destroyInsumo($fichaId, $insumoId)
    {
        $insumo = \App\Models\InsumoGrooming::where('ficha_id', $fichaId)->findOrFail($insumoId);
        
        // Devolver la cantidad al inventario antes de eliminar el registro
        $producto = \App\Models\Producto::findOrFail($insumo->producto_id);
        $producto->stock += $insumo->cantidad;
        $producto->save();

        $insumo->delete();

        return back()->with('status', 'Insumo eliminado y stock devuelto.');
    }
    
}