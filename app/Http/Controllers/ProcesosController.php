<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\ActoresProceso;
use App\Models\Proceso;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProcesosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Proyecto $proyecto)
    {
        // $all_actores = Actor::where('proyecto', $proyecto->id)->get();
        $procesos = Proceso::where('proyecto', $proyecto->id)->get();
        $procesos->map(function ($proceso) {
            $data = ActoresProceso::where('proceso', $proceso->id)->get();
            $actores = $data->map(function ($proceso) {
                return Actor::find($proceso->actor);
            });
            $proceso->actores = $actores;
            return $proceso;
        });
        return Inertia::render('Procesos/Visualizar', ['procesos' => $procesos, 'proyecto' => $proyecto]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Proyecto $proyecto)
    {
        $all_actores = Actor::where('proyecto', $proyecto->id)->get();
        return Inertia::render('Procesos/Nuevo', ['proyecto' => $proyecto, 'actores' => $all_actores]);
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
            'nombre_plantilla' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'entrada' => 'required|string',
            'proyecto' => 'required|numeric',
            'image' => 'required|file'
        ]);


        $img = $request->file('image', null);
        $image = sha1(date('YmdHis') . Str::random(30)) . '.' . $img->extension();
        Storage::disk('public')->putFileAs("procesos", $img, $image);


        $proyecto = Proyecto::find($request->proyecto);
        $actores = $request->actores;

        $proceso = new Proceso();
        $proceso->nombre_plantilla = $request->nombre_plantilla;
        $proceso->nombre = $request->nombre;
        $proceso->descripcion = $request->descripcion;
        $proceso->entrada = $request->entrada;
        $proceso->proyecto = $proyecto->id;
        $proceso->image = $image;
        $proceso->save();


        foreach ($actores as $actor) {
            $actor_proceso = new ActoresProceso();
            $actor_proceso->proceso = $proceso->id;
            $actor_proceso->actor = $actor['id'];
            $actor_proceso->save();
        }

        return redirect("/procesos/proyecto/{$proyecto->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function show(Proceso $proceso)
    {
        $all_actores = Actor::where('proyecto', $proceso->proyecto)->get();

        $data = ActoresProceso::where('proceso', $proceso->id)->get();
        $actores = $data->map(function ($proceso) {
            return Actor::find($proceso->actor);
        });
        $proceso->actores = $actores;
        return Inertia::render('Procesos/Editar', ['actores' => $all_actores, 'proceso' => $proceso]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function edit(Proceso $proceso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'nombre_plantilla' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'entrada' => 'required|string',
        ]);

        $actores = $request->actores;
        $proceso = Proceso::find($request->id);

        $img = $request->file('image', null);
        if ($img !== null) {
            $image = sha1(date('YmdHis') . Str::random(30)) . '.' . $img->extension();
            Storage::disk('public')->putFileAs("procesos", $img, $image);
            $proceso->image = $image;
        }


        $proceso->nombre_plantilla = $request->nombre_plantilla;
        $proceso->nombre = $request->nombre;
        $proceso->descripcion = $request->descripcion;
        $proceso->entrada = $request->entrada;
        $proceso->save();


        ActoresProceso::where('proceso', $proceso->id)->delete();
        foreach ($actores as $actor) {
            $actor_proceso = new ActoresProceso();
            $actor_proceso->proceso = $proceso->id;
            $actor_proceso->actor = $actor['id'];
            $actor_proceso->save();
        }


        return redirect("/procesos/proyecto/{$proceso->proyecto}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proceso  $proceso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proceso $proceso)
    {
        $proceso->delete();
    }
}
