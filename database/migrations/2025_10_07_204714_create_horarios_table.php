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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('dia_id')->constrained('dias')->onDelete('cascade');
            $table->foreignId('bloque_hora_id')->constrained('bloque_horas')->onDelete('cascade');
            $table->year('ciclo_lectivo');
            $table->foreignId('pof_id')->constrained('pofs')->onDelete('cascade')->nullable();
            $table->enum('condicion_docente', ['Titular', 'Interino', 'Suplente']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
