<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Requerimiento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RequerimientosController extends Controller
{
    public function index(Proyecto $proyecto)
    {
        $proyecto->requerimientos;
        return Inertia::render('Requerimientos/Visualizar', ['proyecto' => $proyecto]);
    }

    public function create(Proyecto $proyecto)
    {
        return Inertia::render('Requerimientos/Nuevo', ['proyecto' => $proyecto]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'clave' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'is_funcional' => 'required|boolean',
        ]);

        $clave = $request->clave;
        $descripcion = $request->descripcion;
        $is_funcional = $request->is_funcional;
        $proyecto = $request->proyecto;


        $requerimiento = new Requerimiento();

        $requerimiento->clave = $clave;
        $requerimiento->descripcion = $descripcion;
        $requerimiento->is_funcional = $is_funcional;
        $requerimiento->proyecto = $proyecto;

        $requerimiento->save();

        return redirect("/requerimientos/proyecto/{$proyecto}");
    }

    public function edit(Requerimiento $requerimiento)
    {
        $proyecto = Proyecto::find($requerimiento->proyecto);
        return Inertia::render('Requerimientos/Nuevo', ['requerimiento' => $requerimiento, 'proyecto' => $proyecto]);
    }

    public function update(Requerimiento $requerimiento, Request $request)
    {
        $request->validate([
            'clave' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'is_funcional' => 'required|boolean',
        ]);

        $clave = $request->clave;
        $descripcion = $request->descripcion;
        $is_funcional = $request->is_funcional;

        $requerimiento->clave = $clave;
        $requerimiento->descripcion = $descripcion;
        $requerimiento->is_funcional = $is_funcional;
        $requerimiento->save();

        return redirect("/requerimientos/proyecto/{$requerimiento->proyecto}");
    }

    public function destroy(Requerimiento $requerimiento)
    {
        $requerimiento->delete();
    }
}
