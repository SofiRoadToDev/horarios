<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Pof;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controlador para el dashboard de administración
 */
class AdminController extends Controller
{
    /**
     * Muestra el dashboard principal con estadísticas
     */
    public function index(): Response
    {
        // Obtener totales
        $totalDocentes = Docente::count();
        $totalCursos = Curso::count();
        $totalMaterias = Materia::count();

        // Obtener POF recientes (últimas 10)
        $pofsRecientes = Pof::with(['docente', 'materia', 'curso'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($pof) {
                return [
                    'id' => $pof->id,
                    'tipo' => $pof->tipo,
                    'docente' => $pof->docente->nombre . ' ' . $pof->docente->apellido,
                    'materia' => $pof->materia->nombre,
                    'curso' => $pof->curso->codigo,
                    'fecha' => $pof->fecha,
                    'obligaciones' => $pof->obligaciones,
                ];
            });

        return Inertia::render('admin/index', [
            'stats' => [
                'docentes' => $totalDocentes,
                'cursos' => $totalCursos,
                'materias' => $totalMaterias,
            ],
            'pofsRecientes' => $pofsRecientes,
        ]);
    }
}
