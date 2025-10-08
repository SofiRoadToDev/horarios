<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo',
        'ciclo',
        'turno',
        'preceptor_id',
    ];

    public function preceptor(): BelongsTo
    {
        return $this->belongsTo(Preceptor::class);
    }

    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class);
    }

    public function pofs(): HasMany
    {
        return $this->hasMany(Pof::class);
    }

    /**
     * Relación many-to-many con Materias
     */
    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class, 'cursos_materias');
    }
}
