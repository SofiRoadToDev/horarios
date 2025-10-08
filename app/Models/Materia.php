<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materia extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'departamento_id',
    ];

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
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
     * Relación many-to-many con Cursos
     */
    public function cursos(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class, 'cursos_materias');
    }
}
