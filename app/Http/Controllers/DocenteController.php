<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Docente;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DocenteController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Docentes/Index', [
            'docentes' => Docente::all(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Docentes/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|unique:docentes,dni',
        ]);

        Docente::create($request->all());

        return redirect()->route('docentes.index');
    }

    public function show(Docente $docente): Response
    {
        return Inertia::render('Docentes/Show', [
            'docente' => $docente,
        ]);
    }

    public function edit(Docente $docente): Response
    {
        return Inertia::render('Docentes/Edit', [
            'docente' => $docente,
        ]);
    }

    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|unique:docentes,dni,' . $docente->id,
        ]);

        $docente->update($request->all());

        return redirect()->route('docentes.index');
    }

    public function destroy(Docente $docente)
    {
        $docente->delete();

        return redirect()->route('docentes.index');
    }
}
