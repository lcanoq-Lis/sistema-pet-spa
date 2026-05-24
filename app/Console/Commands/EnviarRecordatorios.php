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

        $citas = Cita::with(['mascota', 'servicio', 'groomer'])
            ->whereDate('fecha_hora_inicio', $manana)
            ->whereIn('estado', ['confirmada', 'agendada'])
            ->get();

        foreach ($citas as $cita) {
            $cliente = \App\Models\User::find($cita->creado_por_usuario_id);
            if (!$cliente) continue;

            try {
                Mail::send('emails.recordatorio_cita', [
                    'cita'    => $cita,
                    'cliente' => $cliente,
                ], function($m) use ($cliente) {
                    $m->to($cliente->email)
                      ->subject('⏰ Recordatorio: tu cita es mañana — Pet Spa');
                });
            } catch (\Exception $e) {
                \Log::error('Error recordatorio: ' . $e->getMessage());
            }
        }

        $this->info("Recordatorios enviados: {$citas->count()}");
    }
}