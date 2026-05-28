<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('insumos_grooming', function (Blueprint $table) {
            $table->enum('estado', ['usado', 'devuelto', 'desperdiciado'])
                  ->default('usado')
                  ->after('unidad');
        });
    }

    public function down(): void {
        Schema::table('insumos_grooming', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};