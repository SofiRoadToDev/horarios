<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Horario;
use App\Models\BloqueHora;
use App\Models\Dia;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controlador para gestión de cursos
 */
class CursoController extends Controller
{
    /**
     * Muestra listado de todos los cursos
     */
    public function index(): Response
    {
        $cursos = Curso::with('preceptor')
            ->orderBy('ciclo')
            ->orderBy('codigo')
            ->get()
            ->map(function ($curso) {
                return [
                    'id' => $curso->id,
                    'codigo' => $curso->codigo,
                    'ciclo' => $curso->ciclo,
                    'turno' => $curso->turno,
                    'preceptor' => $curso->preceptor
                        ? $curso->preceptor->nombre . ' ' . $curso->preceptor->apellido
                        : 'Sin asignar',
                ];
            });

        return Inertia::render('admin/cursos/index', [
            'cursos' => $cursos,
        ]);
    }

    /**
     * Muestra el horario completo de un curso específico
     */
    public function show(string $id): Response
    {
        $curso = Curso::with('preceptor')->findOrFail($id);

        // Obtener todos los días (Lunes a Viernes)
        $dias = Dia::orderBy('id')->get();

        // Obtener bloques horarios según el turno del curso
        $bloqueHoras = BloqueHora::where('turno', $curso->turno)
            ->orderBy('id')
            ->get();

        // Obtener todos los horarios del curso con relaciones
        $horarios = Horario::where('curso_id', $id)
            ->with(['docente', 'materia', 'dia', 'bloqueHora'])
            ->get();

        // Construir matriz de horarios [bloque_hora_id][dia_id] = datos
        $horarioGrid = [];
        foreach ($horarios as $horario) {
            $bloqueId = $horario->bloque_hora_id;
            $diaId = $horario->dia_id;

            // Obtener inicial de condición docente (T, I, S)
            $condicion = substr($horario->condicion_docente, 0, 1);

            $docenteConCondicion = $horario->docente->nombre . ' ' .
                                   $horario->docente->apellido . ' ' .
                                   $condicion;

            // Si ya existe un docente en esta celda, agregar con "/"
            if (isset($horarioGrid[$bloqueId][$diaId])) {
                $horarioGrid[$bloqueId][$diaId]['docentes'][] = $docenteConCondicion;
            } else {
                $horarioGrid[$bloqueId][$diaId] = [
                    'materia' => $horario->materia->nombre,
                    'docentes' => [$docenteConCondicion],
                ];
            }
        }

        return Inertia::render('admin/cursos/show', [
            'curso' => [
                'id' => $curso->id,
                'codigo' => $curso->codigo,
                'ciclo' => $curso->ciclo,
                'turno' => $curso->turno,
                'preceptor' => $curso->preceptor
                    ? $curso->preceptor->nombre . ' ' . $curso->preceptor->apellido
                    : 'Sin asignar',
            ],
            'dias' => $dias->map(fn($dia) => [
                'id' => $dia->id,
                'nombre' => $dia->nombre,
            ]),
            'bloqueHoras' => $bloqueHoras->map(fn($bloque) => [
                'id' => $bloque->id,
                'bloque' => $bloque->bloque,
            ]),
            'horarioGrid' => $horarioGrid,
        ]);
    }
}
