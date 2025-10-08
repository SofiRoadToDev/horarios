<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use App\Models\Docente;
use App\Models\Curso;
use App\Models\Materia;
use App\Models\Dia;
use App\Models\BloqueHora;
use App\Services\HorarioService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Validation\ValidationException;

class HorarioController extends Controller
{
    protected $horarioService;

    public function __construct(HorarioService $horarioService)
    {
        $this->horarioService = $horarioService;
    }

    public function index(): Response
    {
        $horarios = Horario::with(['docente', 'curso', 'materia', 'dia', 'bloqueHora'])->get();
        return Inertia::render('Horarios/Index', [
            'horarios' => $horarios,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Horarios/Create', [
            'docentes' => Docente::all(),
            'cursos' => Curso::all(),
            'materias' => Materia::all(),
            'dias' => Dia::all(),
            'bloqueHoras' => BloqueHora::all(),
            'condicionesDocente' => ['Titular', 'Interino', 'Suplente'],
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Si la petición espera JSON (desde modal), responder con JSON
            if ($request->expectsJson()) {
                $horario = $this->horarioService->createHorario($request->all());
                return response()->json([
                    'success' => true,
                    'message' => 'Horario creado exitosamente.',
                    'horario' => $horario->load(['docente', 'materia']),
                ], 201);
            }

            // Flujo tradicional con redirect
            $this->horarioService->createHorario($request->all());
            return redirect()->route('horarios.index')->with('success', 'Horario creado exitosamente.');
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors(),
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(Horario $horario): Response
    {
        $horario->load(['docente', 'curso', 'materia', 'dia', 'bloqueHora']);
        return Inertia::render('Horarios/Show', [
            'horario' => $horario,
        ]);
    }

    public function edit(Horario $horario): Response
    {
        $horario->load(['docente', 'curso', 'materia', 'dia', 'bloqueHora']);
        return Inertia::render('Horarios/Edit', [
            'horario' => $horario,
            'docentes' => Docente::all(),
            'cursos' => Curso::all(),
            'materias' => Materia::all(),
            'dias' => Dia::all(),
            'bloqueHoras' => BloqueHora::all(),
            'condicionesDocente' => ['Titular', 'Interino', 'Suplente'],
        ]);
    }

    public function update(Request $request, Horario $horario)
    {
        try {
            $this->horarioService->updateHorario($horario, $request->all());
            return redirect()->route('horarios.index')->with('success', 'Horario actualizado exitosamente.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function destroy(Horario $horario)
    {
        try {
            $this->horarioService->deleteHorario($horario);
            return redirect()->route('horarios.index')->with('success', 'Horario eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el horario: ' . $e->getMessage());
        }
    }
}
