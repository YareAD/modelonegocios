<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Proyecto $proyecto)
    {

        $actores = Actor::where('proyecto', $proyecto->id)->get();
        return Inertia::render('Actores/Visualizar', ['actores' => $actores, 'proyecto' => $proyecto]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Proyecto $proyecto)
    {
        return Inertia::render('Actores/Nuevo', ['proyecto' => $proyecto]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'clave' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'caracteristicas' => 'required|string',
            'relaciones' => 'required|string',
            'responsabilidad' => 'required|string',
            'actividades_entrada' => 'required|string',
            'actividades_salida' => 'required|string',
            'proyecto' => 'required|numeric',
        ]);

        $proyecto = Proyecto::find($request->proyecto);

        $actor = new Actor();
        $actor->clave = $request->clave;
        $actor->nombre = $request->nombre;
        $actor->descripcion = $request->descripcion;
        $actor->caracteristicas = $request->caracteristicas;
        $actor->relaciones = $request->relaciones;
        $actor->responsabilidad = $request->responsabilidad;
        $actor->actividades_entrada = $request->actividades_entrada;
        $actor->actividades_salida = $request->actividades_salida;
        $actor->proyecto = $proyecto->id;
        $actor->save();

        return redirect("/actores/proyecto/{$proyecto->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function show(Actor $actor)
    {
        return Inertia::render('Actores/Editar', ['actor' => $actor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function edit(Actor $actor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'clave' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'caracteristicas' => 'required|string',
            'relaciones' => 'required|string',
            'responsabilidad' => 'required|string',
            'actividades_entrada' => 'required|string',
            'actividades_salida' => 'required|string',
        ]);

        $actor = Actor::find($request->id);
        $actor->clave = $request->clave;
        $actor->nombre = $request->nombre;
        $actor->descripcion = $request->descripcion;
        $actor->caracteristicas = $request->caracteristicas;
        $actor->relaciones = $request->relaciones;
        $actor->responsabilidad = $request->responsabilidad;
        $actor->actividades_entrada = $request->actividades_entrada;
        $actor->actividades_salida = $request->actividades_salida;
        $actor->save();

        return redirect("/actores/proyecto/{$actor->proyecto}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Actor $actor)
    {
        $actor->delete();
    }
}
