<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::orderBy('nombre')->get();
        return view('admin.servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('admin.servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'                => 'required|string|max:150',
            'descripcion'           => 'nullable|string',
            'precio_base'           => 'required|numeric|min:0',
            'duracion_base_minutos' => 'required|integer|min:15',
        ], [
            'nombre.required'                => 'El nombre es obligatorio.',
            'precio_base.required'           => 'El precio es obligatorio.',
            'precio_base.min'                => 'El precio no puede ser negativo.',
            'duracion_base_minutos.required' => 'La duración es obligatoria.',
            'duracion_base_minutos.min'      => 'La duración mínima es 15 minutos.',
        ]);

        // Factor por tamaño automático
        $factores = [
            'xs' => 1.0,
            's'  => 1.0,
            'm'  => 1.15,
            'l'  => 1.30,
            'xl' => 1.50,
        ];

        Servicio::create([
            'nombre'                => $request->nombre,
            'descripcion'           => $request->descripcion,
            'precio_base'           => $request->precio_base,
            'duracion_base_minutos' => $request->duracion_base_minutos,
            'factor_tamano_raza'    => $factores,
            'activo'                => true,
        ]);

        return redirect()->route('admin.servicios.index')
            ->with('status', 'Servicio creado correctamente.');
    }

    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('admin.servicios.edit', compact('servicio'));
    }

    public function update(Request $request, $id)
    {
        $servicio = Servicio::findOrFail($id);

        $request->validate([
            'nombre'                => 'required|string|max:150',
            'descripcion'           => 'nullable|string',
            'precio_base'           => 'required|numeric|min:0',
            'duracion_base_minutos' => 'required|integer|min:15',
        ], [
            'nombre.required'                => 'El nombre es obligatorio.',
            'precio_base.required'           => 'El precio es obligatorio.',
            'precio_base.min'                => 'El precio no puede ser negativo.',
            'duracion_base_minutos.required' => 'La duración es obligatoria.',
            'duracion_base_minutos.min'      => 'La duración mínima es 15 minutos.',
        ]);

        $servicio->update([
            'nombre'                => $request->nombre,
            'descripcion'           => $request->descripcion,
            'precio_base'           => $request->precio_base,
            'duracion_base_minutos' => $request->duracion_base_minutos,
            'activo'                => $request->has('activo'),
        ]);

        return redirect()->route('admin.servicios.index')
            ->with('status', 'Servicio actualizado correctamente.');
    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->activo = false;
        $servicio->save();

        return redirect()->route('admin.servicios.index')
            ->with('status', 'Servicio desactivado correctamente.');
    }
    public function checklist($id)
{
    $servicio = \App\Models\Servicio::with('checklistItems.item')->findOrFail($id);
    $todosItems = \App\Models\ChecklistItemCatalogo::where('activo', true)->orderBy('orden')->get();
    $itemsActivos = $servicio->checklistItems->pluck('item_id')->toArray();
    return view('admin.servicios.checklist', compact('servicio', 'todosItems', 'itemsActivos'));
}

public function guardarChecklist(Request $request, $id)
{
    $servicio = \App\Models\Servicio::findOrFail($id);
    
    // Eliminar los ítems actuales
    \App\Models\ServicioChecklistItem::where('servicio_id', $id)->delete();
    
    // Guardar los nuevos
    $items = $request->input('items', []);
    foreach ($items as $orden => $itemId) {
        \App\Models\ServicioChecklistItem::create([
            'servicio_id' => $id,
            'item_id'     => $itemId,
            'orden'       => $orden,
        ]);
    }

    return back()->with('status', '✅ Checklist del servicio actualizado.');
}
}