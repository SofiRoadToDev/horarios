<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Horario;
use App\Models\BloqueHora;
use App\Models\Dia;
use App\Models\Docente;
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

        // Obtener bloques horarios de mañana y tarde
        $bloqueHorasMañana = BloqueHora::where('turno', 'Mañana')
            ->orderBy('id')
            ->get();

        $bloqueHorasTarde = BloqueHora::where('turno', 'Tarde')
            ->orderBy('id')
            ->get();

        // Obtener todos los horarios del curso con relaciones
        $horarios = Horario::where('curso_id', $id)
            ->with(['docente', 'materia', 'dia', 'bloqueHora'])
            ->get();

        // Construir matriz de horarios [bloque_hora_id][dia_id] = datos
        $horarioGridMañana = [];
        $horarioGridTarde = [];

        foreach ($horarios as $horario) {
            $bloqueId = $horario->bloque_hora_id;
            $diaId = $horario->dia_id;

            // Obtener inicial de condición docente (T, I, S)
            $condicion = substr($horario->condicion_docente, 0, 1);

            $docenteConCondicion = $horario->docente->nombre . ' ' .
                                   $horario->docente->apellido . ' ' .
                                   $condicion;

            // Determinar si es turno mañana o tarde
            $turnoBloque = $horario->bloqueHora->turno;

            if ($turnoBloque === 'Mañana') {
                // Si ya existe un docente en esta celda, agregar con "/"
                if (isset($horarioGridMañana[$bloqueId][$diaId])) {
                    $horarioGridMañana[$bloqueId][$diaId]['docentes'][] = $docenteConCondicion;
                } else {
                    $horarioGridMañana[$bloqueId][$diaId] = [
                        'materia' => $horario->materia->nombre,
                        'docentes' => [$docenteConCondicion],
                    ];
                }
            } else {
                // Turno Tarde
                if (isset($horarioGridTarde[$bloqueId][$diaId])) {
                    $horarioGridTarde[$bloqueId][$diaId]['docentes'][] = $docenteConCondicion;
                } else {
                    $horarioGridTarde[$bloqueId][$diaId] = [
                        'materia' => $horario->materia->nombre,
                        'docentes' => [$docenteConCondicion],
                    ];
                }
            }
        }

        // Obtener POFs activos del curso actual
        $pofs = \App\Models\Pof::where('curso_id', $id)
            ->where('tipo', 'Alta')
            ->with(['docente', 'materia'])
            ->get()
            ->map(function($pof) {
                return [
                    'id' => $pof->id,
                    'docente' => $pof->docente->nombre . ' ' . $pof->docente->apellido,
                    'materia' => $pof->materia->nombre,
                    'condicion_docente' => $pof->condicion_docente,
                    'obligaciones' => $pof->obligaciones,
                ];
            });

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
            'bloqueHorasMañana' => $bloqueHorasMañana->map(fn($bloque) => [
                'id' => $bloque->id,
                'bloque' => $bloque->bloque,
            ]),
            'bloqueHorasTarde' => $bloqueHorasTarde->map(fn($bloque) => [
                'id' => $bloque->id,
                'bloque' => $bloque->bloque,
            ]),
            'horarioGridMañana' => $horarioGridMañana,
            'horarioGridTarde' => $horarioGridTarde,
            'pofs' => $pofs,
        ]);
    }
}
