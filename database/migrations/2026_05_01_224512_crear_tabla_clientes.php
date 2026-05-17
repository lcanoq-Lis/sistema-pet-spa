<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('clientes')) {
            Schema::create('clientes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
                $table->string('nombre', 100);
                $table->string('apellido', 100)->nullable();
                $table->string('telefono', 30)->nullable();
                $table->string('direccion', 255)->nullable();
                $table->enum('canal_notificacion', ['email','whatsapp','sms','telegram'])->default('whatsapp');
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('clientes');
    }
};