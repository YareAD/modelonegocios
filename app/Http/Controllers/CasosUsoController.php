<?php

namespace App\Http\Controllers;

use App\Models\CasosUso;
use App\Models\CasoUsoRequerimiento;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CasosUsoController extends Controller
{
    public function index(Proyecto $proyecto)
    {
        $proyecto->casosUso->map(function ($item) {
            $requerimientos =  $item->pivot_requerimientos;
            return $requerimientos->map(function ($re) {
                return $re->requerimiento;
            });
        });
        return Inertia::render('CasosUso/Visualizar', ['proyecto' => $proyecto]);
    }

    public function create(Proyecto $proyecto)
    {
        $proyecto->requerimientos;
        return Inertia::render('CasosUso/Nuevo', ['proyecto' => $proyecto]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'clave' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'proyecto' => 'required|numeric',
        ]);

        $clave = $request->clave;
        $descripcion = $request->descripcion;
        $requerimientos = $request->requerimientos ?? [];
        $proyecto = $request->proyecto;

        $casoUso = new CasosUso();
        $casoUso->clave = $clave;
        $casoUso->descripcion = $descripcion;
        $casoUso->proyecto = $proyecto;
        $casoUso->save();


        foreach ($requerimientos as $vr) {
            $caso_uso_requerimineto = new CasoUsoRequerimiento();
            $caso_uso_requerimineto->caso_de_uso_id = $casoUso->id;
            $caso_uso_requerimineto->requerimiento_id = $vr['id'];
            $caso_uso_requerimineto->save();
        }

        return redirect("/casos-uso/proyecto/{$proyecto}");
    }

    public function edit(CasosUso $casoUso)
    {
        $proyecto = Proyecto::find($casoUso->proyecto);
        $proyecto->requerimientos;

        $casoUso->requerimientos;
        return Inertia::render('CasosUso/Nuevo', ['proyecto' => $proyecto, 'casoUso' => $casoUso]);
    }

    public function update(CasosUso $casoUso, Request $request)
    {
        $request->validate([
            'clave' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        $clave = $request->clave;
        $descripcion = $request->descripcion;
        $requerimientos = $request->requerimientos ?? [];


        $casoUso->clave = $clave;
        $casoUso->descripcion = $descripcion;
        $casoUso->save();

        $casoUso->pivot_requerimientos()->delete();

        foreach ($requerimientos as $vr) {
            $caso_uso_requerimineto = new CasoUsoRequerimiento();
            $caso_uso_requerimineto->caso_de_uso_id = $casoUso->id;
            $caso_uso_requerimineto->requerimiento_id = $vr['id'];
            $caso_uso_requerimineto->save();
        }

        return redirect("/casos-uso/proyecto/{$casoUso->proyecto}");
    }

    public function destroy(CasosUso $casoUso)
    {

        $casoUso->delete();
    }
}
