<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notificacion;
use App\Models\Cita;
use App\Models\Cliente;
use Illuminate\Support\Facades\Mail;

class NotificacionController extends Controller
{
    public function index()
    {
        // CAMBIADO: Se reemplazó 'created_at' por 'creado_en' que es el estándar de tu base de datos
        $notificaciones = Notificacion::with(['cliente', 'cita.mascota'])
            ->orderBy('creado_en', 'desc') 
            ->paginate(20);

        return view('admin.notificaciones.index', compact('notificaciones'));
    }

    public static function enviarConfirmacion(Cita $cita)
        {
            $cita->load(['mascota.duenos.usuario', 'servicio']);

            $clienteRelacion = $cita->mascota->duenos->first();
            if (!$clienteRelacion) return;

            $cliente = $clienteRelacion;
            $email   = $cliente->usuario->email;

            $notificacion = Notificacion::create([
                'cliente_id'         => $cliente->id,
                'cita_id'            => $cita->id,
                'tipo_evento'        => 'confirmacion',
                'canal'              => 'email',
                'destino'            => $email,
                'contenido'          => "Tu cita para {$cita->mascota->nombre} el {$cita->fecha_hora_inicio->format('d/m/Y H:i')} ha sido confirmada.",
                'fecha_programacion' => now(),
                'estado'             => 'pendiente',
            ]);

            try {
                Mail::send('emails.notificacion_cita', [
                    'tipo'    => 'confirmada',
                    'cita'    => $cita,
                    'cliente' => $cliente,
                ], function($m) use ($email) {
                    $m->to($email)->subject('✅ Cita confirmada - Pet Spa');
                });

                $notificacion->estado      = 'enviado';
                $notificacion->fecha_envio = now();
                $notificacion->save();

            } catch (\Exception $e) {
                $notificacion->estado = 'fallido';
                $notificacion->save();
            }
        }

   public static function enviarListaParaRecoger(Cita $cita)
{
    // Cargar relaciones necesarias
    $cita->load(['mascota.duenos.usuario', 'servicio']);

    $clienteRelacion = $cita->mascota->duenos->first();
    if (!$clienteRelacion) return;

    $cliente = $clienteRelacion;
    $email   = $cliente->usuario->email;

    $notificacion = Notificacion::create([
        'cliente_id'         => $cliente->id,
        'cita_id'            => $cita->id,
        'tipo_evento'        => 'listo_recoger',
        'canal'              => 'email',
        'destino'            => $email,
        'contenido'          => "{$cita->mascota->nombre} ya está listo para ser recogido.",
        'fecha_programacion' => now(),
        'estado'             => 'pendiente',
    ]);

    try {
        Mail::send('emails.notificacion_cita', [
            'tipo'    => 'listo_recoger',
            'cita'    => $cita,
            'cliente' => $cliente,
        ], function($m) use ($email) {
            $m->to($email)->subject('🐾 Tu mascota está lista - Pet Spa');
        });

        $notificacion->estado      = 'enviado';
        $notificacion->fecha_envio = now();
        $notificacion->save();

    } catch (\Exception $e) {
        $notificacion->estado = 'fallido';
        $notificacion->save();
    }
}
public static function enviarNotificacionGroomer(Cita $cita)
{
    $cita->load(['mascota', 'servicio', 'groomer.usuario']);

    $groomer = $cita->groomer;
    if (!$groomer || !$groomer->usuario) return;

    $email = $groomer->usuario->email;

    try {
        Mail::send('emails.notificacion_groomer', [
            'cita'    => $cita,
            'groomer' => $groomer,
        ], function($m) use ($email) {
            $m->to($email)->subject('📅 Nueva cita asignada - Pet Spa');
        });
    } catch (\Exception $e) {
        // Si falla el email no interrumpir el flujo
    }
}
public static function enviarNotificacionRecepcion(Cita $cita)
{
    $cita->load(['mascota', 'servicio', 'groomer']);

    // Buscar usuarios con rol recepcion
    $recepcionistas = \App\Models\User::whereHas('rol', function($q) {
        $q->where('nombre', 'recepcion');
    })->where('activo', true)->get();

    foreach ($recepcionistas as $recepcionista) {
        try {
            \Illuminate\Support\Facades\Mail::send('emails.notificacion_recepcion', [
                'cita'          => $cita,
                'recepcionista' => $recepcionista,
            ], function($m) use ($recepcionista) {
                $m->to($recepcionista->email)
                  ->subject('📅 Nueva cita por confirmar - Pet Spa');
            });
        } catch (\Exception $e) {
            // Si falla no interrumpir el flujo
        }
    }
}
}
