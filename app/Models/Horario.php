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
        'pof_id',
        'dia_id',
        'bloque_hora_id',
    ];

    /**
     * Relación directa con POF
     */
    public function pof(): BelongsTo
    {
        return $this->belongsTo(Pof::class);
    }

    /**
     * Relaciones indirectas a través del POF
     */
    public function docente(): BelongsTo
    {
        return $this->pof->belongsTo(Docente::class);
    }

    public function curso(): BelongsTo
    {
        return $this->pof->belongsTo(Curso::class);
    }

    public function materia(): BelongsTo
    {
        return $this->pof->belongsTo(Materia::class);
    }

    /**
     * Relaciones directas
     */
    public function dia(): BelongsTo
    {
        return $this->belongsTo(Dia::class);
    }

    public function bloqueHora(): BelongsTo
    {
        return $this->belongsTo(BloqueHora::class);
    }

    /**
     * Accessors para obtener datos del POF fácilmente
     */
    public function getDocenteIdAttribute(): ?int
    {
        return $this->pof?->docente_id;
    }

    public function getCursoIdAttribute(): ?int
    {
        return $this->pof?->curso_id;
    }

    public function getMateriaIdAttribute(): ?int
    {
        return $this->pof?->materia_id;
    }

    public function getCondicionDocenteAttribute(): ?string
    {
        return $this->pof?->condicion_docente;
    }

    public function getCicloLectivoAttribute(): ?string
    {
        return $this->pof?->ciclo_lectivo;
    }
}
