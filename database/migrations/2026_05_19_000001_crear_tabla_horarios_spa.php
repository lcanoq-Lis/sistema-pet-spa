<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('horarios_spa', function (Blueprint $table) {
            $table->id();
            // 0=Domingo, 1=Lunes ... 6=Sábado
            $table->tinyInteger('dia_semana')->unsigned()->comment('0=Dom, 1=Lun, 2=Mar, 3=Mie, 4=Jue, 5=Vie, 6=Sab');
            $table->time('hora_apertura')->default('09:00:00');
            $table->time('hora_cierre')->default('18:00:00');
            $table->boolean('activo')->default(true)->comment('false = día cerrado');
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamp('actualizado_en')->useCurrent()->useCurrentOnUpdate();
        });

        // Insertar horario por defecto: lunes a viernes 9-18, sábado 9-14, dom cerrado
        DB::table('horarios_spa')->insert([
            ['dia_semana' => 0, 'hora_apertura' => '09:00:00', 'hora_cierre' => '18:00:00', 'activo' => false], // Dom
            ['dia_semana' => 1, 'hora_apertura' => '09:00:00', 'hora_cierre' => '18:00:00', 'activo' => true],  // Lun
            ['dia_semana' => 2, 'hora_apertura' => '09:00:00', 'hora_cierre' => '18:00:00', 'activo' => true],  // Mar
            ['dia_semana' => 3, 'hora_apertura' => '09:00:00', 'hora_cierre' => '18:00:00', 'activo' => true],  // Mie
            ['dia_semana' => 4, 'hora_apertura' => '09:00:00', 'hora_cierre' => '18:00:00', 'activo' => true],  // Jue
            ['dia_semana' => 5, 'hora_apertura' => '09:00:00', 'hora_cierre' => '18:00:00', 'activo' => true],  // Vie
            ['dia_semana' => 6, 'hora_apertura' => '09:00:00', 'hora_cierre' => '14:00:00', 'activo' => true],  // Sab
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('horarios_spa');
    }
};
