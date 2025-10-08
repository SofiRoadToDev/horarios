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
        Schema::create('pofs', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['Alta', 'Baja']);
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->enum('condicion_docente', ['Titular', 'Interino', 'Suplente']);
            $table->date('ciclo_lectivo');
            $table->date('fecha');
            $table->integer('obligaciones');// es la cantidad de horas catedra del docente en una materia y curso especifico, equivale a 40 minutos. Los horarios bloques representan una obligacion cada uno
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pofs');
    }
};
