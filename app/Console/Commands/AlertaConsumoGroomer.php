<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Groomer;
use App\Models\InsumoGrooming;

class AlertaConsumoGroomer extends Command
{
    protected $signature   = 'groomers:alerta-consumo';
    protected $description = 'Envía alerta si un groomer tiene alto consumo de insumos';

    public function handle()
    {
        $semanaInicio = now()->startOfWeek();
        $limite       = 20; // cantidad total de insumos por semana

        $groomers = Groomer::with('usuario')->where('activo', true)->get();

        foreach ($groomers as $groomer) {
            $totalInsumos = InsumoGrooming::whereHas('ficha', function($q) use ($groomer) {
                    $q->whereHas('cita', fn($q2) => $q2->where('groomer_id', $groomer->id));
                })
                ->where('estado', '!=', 'devuelto')
                ->where('creado_en', '>=', $semanaInicio)
                ->sum('cantidad');

            if ($totalInsumos >= $limite) {
                // Notificar al admin
                $admins = \App\Models\User::whereHas('rol', fn($q) => $q->where('nombre', 'admin'))->get();
                foreach ($admins as $admin) {
                    try {
                        \Illuminate\Support\Facades\Mail::send(
                            'emails.alerta_consumo_groomer',
                            ['groomer' => $groomer, 'total' => $totalInsumos, 'limite' => $limite],
                            function($m) use ($admin, $groomer) {
                                $m->to($admin->email)
                                  ->subject("⚠️ Alto consumo de insumos — {$groomer->nombre}");
                            }
                        );
                    } catch (\Exception $e) {
                        \Log::error('Error alerta consumo: ' . $e->getMessage());
                    }
                }
                $this->info("Alerta enviada para groomer: {$groomer->nombre} ({$totalInsumos} unidades)");
            }
        }

        $this->info('Revisión de consumo completada.');
    }
}