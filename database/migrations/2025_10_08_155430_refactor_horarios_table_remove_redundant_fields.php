<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Refactorización: El POF ya contiene docente_id, materia_id, curso_id y condicion_docente
     * Solo necesitamos pof_id (obligatorio), dia_id y bloque_hora_id en horarios
     */
    public function up(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
            // Hacer pof_id NOT NULL (antes era nullable)
            $table->foreignId('pof_id')->nullable(false)->change();

            // Eliminar campos redundantes que ya están en POF
            $table->dropForeign(['docente_id']);
            $table->dropForeign(['curso_id']);
            $table->dropForeign(['materia_id']);

            $table->dropColumn([
                'docente_id',
                'curso_id',
                'materia_id',
                'ciclo_lectivo',
                'condicion_docente',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
            // Restaurar campos eliminados
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->year('ciclo_lectivo');
            $table->enum('condicion_docente', ['Titular', 'Interino', 'Suplente']);

            // Volver a hacer pof_id nullable
            $table->foreignId('pof_id')->nullable()->change();
        });
    }
};
