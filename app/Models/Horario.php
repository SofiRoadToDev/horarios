<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horario extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'docente_id',
        'curso_id',
        'materia_id',
        'dia_id',
        'bloque_hora_id',
        'ciclo_lectivo',
        'condicion_docente',
    ];

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    public function dia(): BelongsTo
    {
        return $this->belongsTo(Dia::class);
    }

    public function bloqueHora(): BelongsTo
    {
        return $this->belongsTo(BloqueHora::class);
    }
}
