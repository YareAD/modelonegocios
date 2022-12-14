<?php

namespace App\Http\Controllers;

use App\Models\Artefacto;
use App\Models\DataArtefacto;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ArtefactosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Proyecto $proyecto)
    {
        $artefactos = Artefacto::where('proyecto', $proyecto->id)->get();
        $artefactos->map(function ($artefacto) {
            $artefacto->datos = DataArtefacto::where('artefacto', $artefacto->id)->get();
            return $artefacto;
        });
        return Inertia::render('Artefactos/Visualizar', ['artefactos' => $artefactos, 'proyecto' => $proyecto]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Proyecto $proyecto)
    {
        return Inertia::render('Artefactos/Nuevo', ['proyecto' => $proyecto]);
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
            'proyecto' => 'required|numeric',
        ]);
        $proyecto = Proyecto::find($request->proyecto);

        $datos = $request->datos;

        $artefacto = new Artefacto();
        $artefacto->clave = $request->clave;
        $artefacto->nombre = $request->nombre;
        $artefacto->descripcion = $request->descripcion;
        $artefacto->descripcion = $request->descripcion;
        $artefacto->proyecto = $proyecto->id;
        $artefacto->save();


        foreach ($datos as $dato) {
            $data = new DataArtefacto();
            $data->atributo = $dato['atributo'];
            $data->descripcion = $dato['descripcion'];
            $data->tipo = $dato['tipo'];
            $data->rango = $dato['rango'];
            $data->excepciones = $dato['excepciones'];
            $data->artefacto = $artefacto->id;
            $data->save();
        }
        return redirect("/artefactos/proyecto/{$proyecto->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artefacto  $artefacto
     * @return \Illuminate\Http\Response
     */
    public function show(Artefacto $artefacto)
    {
        $datos = DataArtefacto::where('artefacto', $artefacto->id)->get();
        return Inertia::render('Artefactos/Editar', ['artefacto' => $artefacto, 'datos' => $datos]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Artefacto  $artefacto
     * @return \Illuminate\Http\Response
     */
    public function edit(Artefacto $artefacto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artefacto  $artefacto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'clave' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        $artefacto = Artefacto::find($request->id);
        $artefacto->clave = $request->clave;
        $artefacto->nombre = $request->nombre;
        $artefacto->descripcion = $request->descripcion;
        $artefacto->save();

        return redirect("/artefactos/proyecto/{$artefacto->proyecto}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artefacto  $artefacto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artefacto $artefacto)
    {
        $artefacto->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artefacto  $artefacto
     * @return \Illuminate\Http\Response
     */
    public function destroyDato(DataArtefacto $dato)
    {
        $dato->delete();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDato(Request $request)
    {
        $request->validate([
            'atributo' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'rango' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'excepciones' => 'required|string',
            'artefacto' => 'required|numeric',
        ]);

        $data = new DataArtefacto();
        $data->atributo = $request->atributo;
        $data->descripcion = $request->descripcion;
        $data->tipo = $request->tipo;
        $data->rango = $request->rango;
        $data->excepciones = $request->excepciones;
        $data->artefacto = $request->artefacto;
        $data->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artefacto  $artefacto
     * @return \Illuminate\Http\Response
     */
    public function updateDato(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'atributo' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'rango' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'excepciones' => 'required|string',
        ]);

        $data = DataArtefacto::find($request->id);
        $data->atributo = $request->atributo;
        $data->descripcion = $request->descripcion;
        $data->tipo = $request->tipo;
        $data->rango = $request->rango;
        $data->excepciones = $request->excepciones;
        $data->save();
    }
}
