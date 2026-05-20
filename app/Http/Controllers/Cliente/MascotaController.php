<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogHelper;

class MascotaController extends Controller
{
    public function index()
    {
        $cliente = Cliente::where('usuario_id', Auth::id())->first();

        if (!$cliente) {
            return redirect('/dashboard')->withErrors(['error' => 'No tienes perfil de cliente.']);
        }

        $mascotas = $cliente->mascotas()->where('activo', true)->with('vacunas')->get();

        return view('cliente.mascotas.index', compact('mascotas'));
    }

    public function create()
    {
        return view('cliente.mascotas.create');
    }

    public function store(Request $request)
{
    $request->validate([
    'nombre'               => 'required|string|max:100',
    'especie'              => 'required|string|max:50',
    'especie_otro'         => 'required_if:especie,otro|nullable|string|max:50',
    'raza'                 => 'nullable|string|max:100',
    'tamano'               => 'required|in:xs,s,m,l,xl',
    'peso_kg'              => 'nullable|numeric|min:0',
    'fecha_nacimiento'     => 'nullable|date|before:today',
    'temperamento'         => 'nullable|in:tranquilo,jugueton,agresivo,nervioso,otro',
    'temperamento_otro'    => 'nullable|string|max:100',
    'alergias'             => 'nullable|string',
    'restricciones_medicas'=> 'nullable|string',
], [
    'nombre.required'          => 'El nombre de la mascota es obligatorio.',
    'especie.required'         => 'La especie es obligatoria.',
    'especie_otro.required_if' => 'Debes especificar la especie.',
    'tamano.required'          => 'El tamaño es obligatorio.',
    'tamano.in'                => 'El tamaño seleccionado no es válido.',
    'peso_kg.numeric'          => 'El peso debe ser un número.',
    'peso_kg.min'              => 'El peso no puede ser negativo.',
    'fecha_nacimiento.date'    => 'La fecha de nacimiento no es válida.',
    'fecha_nacimiento.before'  => 'La fecha de nacimiento debe ser anterior a hoy.',
]);

    // Si especie es "otro" usar el campo especificado
    $especie      = $request->especie === 'otro' ? $request->especie_otro : $request->especie;
    $temperamento = $request->temperamento === 'otro' ? $request->temperamento_otro : $request->temperamento;

    $mascota = Mascota::create([
        'nombre'               => $request->nombre,
        'especie'              => $especie,
        'raza'                 => $request->raza,
        'tamano'               => $request->tamano,
        'peso_kg'              => $request->peso_kg,
        'fecha_nacimiento'     => $request->fecha_nacimiento,
        'temperamento'         => $temperamento,
        'alergias'             => $request->alergias,
        'restricciones_medicas'=> $request->restricciones_medicas,
        'activo'               => true,
    ]);
    LogHelper::registrar('mascota_registrada', "Mascota registrada: {$mascota->nombre} ({$mascota->especie})");
    $cliente = Cliente::where('usuario_id', Auth::id())->first();
    $cliente->mascotas()->attach($mascota->id, ['es_primario' => true]);

    return redirect()->route('cliente.mascotas.index')
        ->with('status', '¡Mascota registrada correctamente! 🐾');
}
    public function edit($id)
    {
        $cliente  = Cliente::where('usuario_id', Auth::id())->first();
        $mascota  = $cliente->mascotas()->findOrFail($id);

        return view('cliente.mascotas.edit', compact('mascota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
    'nombre'               => 'required|string|max:100',
    'especie'              => 'required|string|max:50',
    'especie_otro'         => 'required_if:especie,otro|nullable|string|max:50',
    'raza'                 => 'nullable|string|max:100',
    'tamano'               => 'required|in:xs,s,m,l,xl',
    'peso_kg'              => 'nullable|numeric|min:0',
    'fecha_nacimiento'     => 'nullable|date|before:today',
    'temperamento'         => 'nullable|in:tranquilo,jugueton,agresivo,nervioso,otro',
    'temperamento_otro'    => 'nullable|string|max:100',
    'alergias'             => 'nullable|string',
    'restricciones_medicas'=> 'nullable|string',
], [
    'nombre.required'          => 'El nombre de la mascota es obligatorio.',
    'especie.required'         => 'La especie es obligatoria.',
    'especie_otro.required_if' => 'Debes especificar la especie.',
    'tamano.required'          => 'El tamaño es obligatorio.',
    'tamano.in'                => 'El tamaño seleccionado no es válido.',
    'peso_kg.numeric'          => 'El peso debe ser un número.',
    'peso_kg.min'              => 'El peso no puede ser negativo.',
    'fecha_nacimiento.date'    => 'La fecha de nacimiento no es válida.',
    'fecha_nacimiento.before'  => 'La fecha de nacimiento debe ser anterior a hoy.',
]);
        $cliente = Cliente::where('usuario_id', Auth::id())->first();
        $mascota = $cliente->mascotas()->findOrFail($id);
        $mascota->update($request->all());

        return redirect()->route('cliente.mascotas.index')
            ->with('status', 'Mascota actualizada correctamente.');
    }
    public function agregarVacuna(Request $request, $id)
{
    $request->validate([
        'nombre_vacuna'    => 'required|string|max:100',
        'fecha_aplicacion' => 'required|date',
        'fecha_vencimiento'=> 'nullable|date|after:fecha_aplicacion',
        'archivo'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
    ], [
        'nombre_vacuna.required'    => 'El nombre de la vacuna es obligatorio.',
        'fecha_aplicacion.required' => 'La fecha de aplicación es obligatoria.',
        'archivo.mimes'             => 'Solo se permiten PDF, JPG o PNG.',
        'archivo.max'               => 'El archivo no debe superar 5MB.',
    ]);

    $archivoUrl = null;
    if ($request->hasFile('archivo')) {
        $path      = $request->file('archivo')->store('vacunas', 'public');
        $archivoUrl = asset('storage/' . $path);
    }

    \App\Models\VacunaMascota::create([
        'mascota_id'        => $id,
        'nombre_vacuna'     => $request->nombre_vacuna,
        'fecha_aplicacion'  => $request->fecha_aplicacion,
        'fecha_vencimiento' => $request->fecha_vencimiento,
        'observaciones'     => $archivoUrl,
    ]);

    return back()->with('status', 'Vacuna registrada correctamente.');
}

    public function destroy($id)
    {
        $cliente = Cliente::where('usuario_id', Auth::id())->first();
        $mascota = $cliente->mascotas()->findOrFail($id);
        $mascota->activo = false;
        $mascota->save();
        LogHelper::registrar('mascota_eliminada', "Mascota eliminada: {$mascota->nombre}");
        return redirect()->route('cliente.mascotas.index')
            ->with('status', 'Mascota eliminada correctamente.');
    }
}