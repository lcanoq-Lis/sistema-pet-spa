<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cita;
use Illuminate\Support\Facades\Mail;

class EnviarRecordatorios extends Command
{
    protected $signature   = 'citas:recordatorios';
    protected $description = 'Envía recordatorios de citas para mañana';

   public function handle()
{
    $manana = now()->addDay()->toDateString();

    // Recordatorio 24 horas antes
    $citas24h = Cita::with(['mascota', 'servicio', 'groomer'])
        ->whereDate('fecha_hora_inicio', $manana)
        ->whereIn('estado', ['confirmada', 'agendada'])
        ->get();

    foreach ($citas24h as $cita) {
        $cliente = \App\Models\User::find($cita->creado_por_usuario_id);
        if (!$cliente) continue;
        try {
            Mail::send('emails.recordatorio_cita', [
                'cita'    => $cita,
                'cliente' => $cliente,
                'horas'   => 24,
            ], function($m) use ($cliente) {
                $m->to($cliente->email)
                  ->subject('⏰ Recordatorio: tu cita es mañana — Pet Spa');
            });
        } catch (\Exception $e) {
            \Log::error('Error recordatorio 24h: ' . $e->getMessage());
        }
    }

    // Recordatorio 2 horas antes
    $en2horas = now()->addHours(2);
    $citas2h = Cita::with(['mascota', 'servicio', 'groomer'])
        ->where('fecha_hora_inicio', '>=', $en2horas->copy()->subMinutes(5))
        ->where('fecha_hora_inicio', '<=', $en2horas->copy()->addMinutes(5))
        ->whereIn('estado', ['confirmada', 'agendada'])
        ->get();

    foreach ($citas2h as $cita) {
        $cliente = \App\Models\User::find($cita->creado_por_usuario_id);
        if (!$cliente) continue;
        try {
            Mail::send('emails.recordatorio_cita', [
                'cita'    => $cita,
                'cliente' => $cliente,
                'horas'   => 2,
            ], function($m) use ($cliente) {
                $m->to($cliente->email)
                  ->subject('⏰ Tu cita es en 2 horas — Pet Spa');
            });
        } catch (\Exception $e) {
            \Log::error('Error recordatorio 2h: ' . $e->getMessage());
        }
    }

    $this->info("Recordatorios enviados: 24h={$citas24h->count()}, 2h={$citas2h->count()}");
}
    
}