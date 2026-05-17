<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuthLog;
use App\Models\Groomer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Helpers\LogHelper;

class PersonalController extends Controller
{
    public function index()
    {
        $personal = User::whereHas('rol', function ($q) {
            $q->whereIn('nombre', ['groomer', 'recepcion']);
        })->with('rol')->get();

        return view('admin.personal.index', compact('personal'));
    }

    public function create()
    {
        return view('admin.personal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|unique:users,email',
            'rol'         => 'required|in:groomer,recepcion',
            'telefono'    => 'nullable|string|max:30',
            'especialidad'=> 'nullable|string|max:150',
        ], [
            'name.required'  => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email'    => 'El correo no tiene un formato válido.',
            'email.unique'   => 'Este correo ya está registrado en el sistema.',
            'rol.required'   => 'Debes seleccionar un rol.',
        ]);

        $rol = Role::where('nombre', $request->rol)->first();

        // Generar contraseña temporal
        $passwordTemporal = Str::random(10) . '@1A';

        $usuario = User::create([
            'name'             => $request->name,
            'email'            => $request->email,
            'password'         => Hash::make($passwordTemporal),
            'rol_id'           => $rol->id,
            'email_verificado' => true,
            'activo'           => true,
        ]);

        // Si es groomer crear perfil
        if ($request->rol === 'groomer') {
            Groomer::create([
                'usuario_id'   => $usuario->id,
                'nombre'       => $request->name,
                'telefono'     => $request->telefono,
                'especialidad' => $request->especialidad,
            ]);
        }

        // Enviar email con contraseña temporal
        Mail::send('emails.bienvenida_personal', [
            'nombre'   => $request->name,
            'email'    => $request->email,
            'password' => $passwordTemporal,
            'rol'      => $request->rol,
        ], function ($m) use ($request) {
            $m->to($request->email)->subject('Bienvenido al equipo - Pet Spa');
        });

        // Log al final
        LogHelper::registrar('personal_creado', "Personal creado: {$request->name} - Rol: {$request->rol}");

        return redirect()->route('admin.personal.index')
            ->with('status', 'Personal creado correctamente. Se envió email con credenciales.');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->activo = false;
        $usuario->save();
        LogHelper::registrar('personal_desactivado', "Usuario desactivado: ID #{$id}");

        return redirect()->route('admin.personal.index')
            ->with('status', 'Usuario desactivado correctamente.');
    }
}