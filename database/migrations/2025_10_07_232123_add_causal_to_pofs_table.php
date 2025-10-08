<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pofs', function (Blueprint $table) {
            $table->enum('causal', ['Jubilacion', 'Fallecimiento', 'Lic.art.24', 'cargo_mayor_jearquia', 'Renuncia']);
            $table->string('instrumento_legal');
            $table->string('observaciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pofs', function (Blueprint $table) {
            $table->dropColumn('causal');
            $table->dropColumn('instrumento_legal');
            $table->dropColumn('observaciones');
        });
    }
};
