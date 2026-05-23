<?php
// app/Http/Controllers/Admin/PromocionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promocion;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromocionController extends Controller
{
    public function index()
    {
        $promociones = Promocion::with('servicio')->orderBy('creado_en', 'desc')->get();
        $servicios   = Servicio::where('activo', true)->orderBy('nombre')->get();
        return view('admin.promociones.index', compact('promociones', 'servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:150',
            'tipo'        => 'required|in:porcentaje,monto_fijo,cliente_frecuente',
            'valor'       => 'required|numeric|min:0.01',
            'servicio_id' => 'nullable|exists:servicios,id',
            'min_citas'   => 'nullable|integer|min:1',
            'fecha_inicio'=> 'nullable|date',
            'fecha_fin'   => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        Promocion::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'tipo'        => $request->tipo,
            'valor'       => $request->valor,
            'servicio_id' => $request->servicio_id ?: null,
            'min_citas'   => $request->min_citas ?: null,
            'fecha_inicio'=> $request->fecha_inicio ?: null,
            'fecha_fin'   => $request->fecha_fin ?: null,
            'activo'      => true,
            'creado_por'  => Auth::id(),
        ]);

        return back()->with('status', 'Promoción creada correctamente.');
    }

    public function toggle($id)
    {
        $promo = Promocion::findOrFail($id);
        $promo->activo = !$promo->activo;
        $promo->save();
        return back()->with('status', 'Estado de la promoción actualizado.');
    }

    public function destroy($id)
    {
        Promocion::findOrFail($id)->delete();
        return back()->with('status', 'Promoción eliminada.');
    }
}
