<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Preceptor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class PreceptorController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Preceptores/Index', [
            'preceptores' => Preceptor::all(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Preceptores/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|unique:preceptores,dni',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Preceptor::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dni' => $request->dni,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('preceptores.index');
    }

    public function show(Preceptor $preceptor): Response
    {
        return Inertia::render('Preceptores/Show', [
            'preceptor' => $preceptor,
        ]);
    }

    public function edit(Preceptor $preceptor): Response
    {
        return Inertia::render('Preceptores/Edit', [
            'preceptor' => $preceptor,
        ]);
    }

    public function update(Request $request, Preceptor $preceptor)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|unique:preceptores,dni,' . $preceptor->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $preceptor->update($data);

        return redirect()->route('preceptores.index');
    }

    public function destroy(Preceptor $preceptor)
    {
        $preceptor->delete();

        return redirect()->route('preceptores.index');
    }
}
