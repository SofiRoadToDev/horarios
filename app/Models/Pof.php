<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo POF (Plan de Ordenamiento de Funciones)
 * Registra altas y bajas de docentes en materias y cursos
 */
class Pof extends Model
{
    protected $fillable = [
        'tipo',
        'docente_id',
        'materia_id',
        'ciclo_lectivo',
        'curso_id',
        'condicion_docente',
        'fecha',
        'obligaciones',
        'causal',
        'instrumento_legal',
        'observaciones',
    ];

    /**
     * Relación con Docente
     */
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    /**
     * Relación con Materia
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    /**
     * Relación con Curso
     */
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }
}
