<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cita_id');
            $table->enum('metodo', ['efectivo', 'qr', 'transferencia'])->default('efectivo');
            $table->decimal('monto', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('referencia', 100)->nullable()->comment('Nro. de transferencia o QR');
            $table->string('observaciones', 300)->nullable();
            $table->enum('estado', ['pendiente', 'pagado', 'anulado'])->default('pendiente');
            $table->unsignedBigInteger('registrado_por')->nullable();
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamp('actualizado_en')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pagos');
    }
};
