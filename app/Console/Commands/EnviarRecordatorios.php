<?php

namespace App\Console\Commands;

use App\Models\Cita;
use App\Models\Notificacion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EnviarRecordatorios extends Command
{
    protected $signature   = 'recordatorios:enviar';
    protected $description = 'Envía recordatorios de citas 24 horas antes';

    public function handle()
    {
        $manana = Carbon::now()->addDays(7); // busca citas en 7 días
        $inicio = Carbon::now()->subHours(24); // rango amplio para probar
        $fin    = Carbon::now()->addDays(10);

        // Citas que son en ~24 horas y no han recibido recordatorio
        $citas = Cita::whereBetween('fecha_hora_inicio', [$inicio, $fin])
            ->whereIn('estado', ['confirmada', 'agendada', 'en_revision'])
            ->whereDoesntHave('notificaciones', function($q) {
                $q->where('tipo_evento', 'recordatorio_24h');
            })
            ->with(['mascota.duenos.usuario', 'servicio', 'groomer'])
            ->get();

        $this->info("Citas encontradas: " . $citas->count());

        foreach ($citas as $cita) {
            $cliente = $cita->mascota->duenos->first();
            if (!$cliente || !$cliente->usuario) continue;

            $email = $cliente->usuario->email;

            $notificacion = Notificacion::create([
                'cliente_id'         => $cliente->id,
                'cita_id'            => $cita->id,
                'tipo_evento'        => 'recordatorio_24h',
                'canal'              => 'email',
                'destino'            => $email,
                'contenido'          => "Recordatorio: Mañana tienes cita para {$cita->mascota->nombre}",
                'fecha_programacion' => now(),
                'estado'             => 'pendiente',
            ]);

            try {
                Mail::send('emails.notificacion_cita', [
                    'tipo'    => 'recordatorio',
                    'cita'    => $cita,
                    'cliente' => $cliente,
                ], function($m) use ($email) {
                    $m->to($email)->subject('⏰ Recordatorio de cita mañana - Pet Spa');
                });

                $notificacion->estado      = 'enviado';
                $notificacion->fecha_envio = now();
                $notificacion->save();

                $this->info("Recordatorio enviado a: $email");

            } catch (\Exception $e) {
                $notificacion->estado = 'fallido';
                $notificacion->save();
                $this->error("Error enviando a $email: " . $e->getMessage());
            }
        }

        $this->info("Proceso completado.");
        return 0;
    }
}