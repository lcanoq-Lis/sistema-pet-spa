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
            'cita_id'            => 'required|exists:citas,id',
            'temperatura_ingreso'=> 'nullable|numeric',
            'estado_inicial'     => 'required|string',
            'notas_internas'     => 'nullable|string',
        ]);

        $cita = Cita::findOrFail($request->cita_id);
        $cita->estado = 'en_progreso';
        $cita->save();

        $ficha = FichaGrooming::create([
            'cita_id'             => $request->cita_id,
            'raza_momento'        => $cita->mascota->raza,
            'tamano_momento'      => $cita->mascota->tamano,
            'temperatura_ingreso' => $request->temperatura_ingreso,
            'estado_inicial'      => $request->estado_inicial,
            'notas_internas'      => $request->notas_internas,
        ]);

        // Guardar checklist
        $items = ChecklistItemCatalogo::where('activo', true)->get();
        foreach ($items as $item) {
            FichaChecklist::create([
                'ficha_id'  => $ficha->id,
                'item_id'   => $item->id,
                'completado'=> false,
            ]);
        }

        return redirect()->route('groomer.ficha.edit', $ficha->id)
            ->with('status', 'Ficha creada. Completa el checklist y cierra la ficha cuando termines.');
    }

    public function edit($id)
    {
        $groomer = Groomer::where('usuario_id', Auth::id())->first();
        $ficha   = FichaGrooming::with(['cita.mascota', 'cita.servicio', 'checklist.item', 'fotos'])
                                ->findOrFail($id);

        return view('groomer.ficha.edit', compact('ficha'));
    }

    public function update(Request $request, $id)
    {
        $ficha = FichaGrooming::findOrFail($id);

        // Actualizar checklist
        if ($request->checklist) {
            foreach ($request->checklist as $itemId => $data) {
                $check = FichaChecklist::where('ficha_id', $ficha->id)
                                       ->where('item_id', $itemId)
                                       ->first();
                if ($check) {
                    $check->completado   = isset($data['completado']);
                    $check->observacion  = $data['observacion'] ?? null;
                    $check->completado_en= isset($data['completado']) ? now() : null;
                    $check->save();
                }
            }
        }

        $ficha->estado_final   = $request->estado_final;
        $ficha->notas_internas = $request->notas_internas;
        $ficha->save();

        return back()->with('status', 'Ficha actualizada.');
    }

   public function cerrar(Request $request, $id)
{
    $ficha = FichaGrooming::with('checklist')->findOrFail($id);

    // Validar checklist completo
    $pendientes = $ficha->checklist->where('completado', false)->count();
    if ($pendientes > 0) {
        return back()->withErrors(['error' => "Faltan $pendientes items del checklist por completar."]);
    }

    $ficha->fecha_cierre = now();
    $ficha->save();

    $ficha->cita->estado = 'completada';
    $ficha->cita->save();

    // Notificar al cliente
    $ficha->cita->load(['mascota', 'servicio']);
    NotificacionController::enviarListaParaRecoger($ficha->cita);

    return redirect()->route('groomer.agenda.index')
        ->with('status', '¡Servicio completado! Se notificó al cliente que puede recoger a su mascota. 🎉');
}
    
}