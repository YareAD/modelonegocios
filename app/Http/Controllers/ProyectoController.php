<?php

namespace App\Http\Controllers;

use App\Http\Fpdf\PDF;
use App\Models\Actor;
use App\Models\ActoresProceso;
use App\Models\Artefacto;
use App\Models\DataArtefacto;
use App\Models\Proceso;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProyectoController extends Controller
{

    public function reporte(Proyecto $proyecto)
    {
        $pdf = new  PDF();
        $pdf->setData($proyecto);
        $pdf->AddPage();

        $numero_table = 0;

        $requerimientos = $proyecto->requerimientos;
        $rf = $requerimientos->filter(function ($value) {
            return $value->is_funcional;
        });

        $rnf = $requerimientos->filter(function ($value) {
            return !$value->is_funcional;
        });

        $pdf->SetWidths([25, 165]);
        $pdf->SetAligns(['L', 'L']);



        $pdf->SetFont('Courier', 'B', 12);
        $pdf->cell(190, 8, "Requerimientos funcionales", 0, 1, 'L', false);

        $pdf->SetFont('Courier', 'B', 10);
        $pdf->Row(['Clave:', 'Descripción']);
        $pdf->SetFont('Courier', '', 10);
        foreach ($rf as $value) {
            $pdf->Row([
                $value->clave,
                $value->descripcion,
            ]);
        }
        $pdf->Ln(10);


        $pdf->SetFont('Courier', 'B', 12);
        $pdf->cell(190, 8, "Requerimientos no funcionales", 0, 1, 'L', false);

        $pdf->SetFont('Courier', 'B', 10);
        $pdf->Row(['Clave:', 'Descripción']);
        $pdf->SetFont('Courier', '', 10);
        foreach ($rnf as $value) {
            $pdf->Row([
                $value->clave,
                $value->descripcion,
            ]);
        }


        $pdf->AddPage();
        $pdf->SetFont('Courier', 'B', 12);
        $pdf->cell(190, 8, "Casos de uso", 0, 1, 'L', false);

        $casos_de_uso = $proyecto->casosUso->map(function ($item) {
            $item->requerimientos;
            return $item;
        });

        $pdf->SetFont('Courier', '', 10);

        foreach ($casos_de_uso as $key => $cu) {
            $numero_table += 1;
            $pdf->Ln(5);
            $pdf->cell(190, 5, utf8_decode($cu->clave), 0, 1, 'C', false);
            $pdf->Ln(5);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Courier', 'B', 10);
            $pdf->cell(190, 5, 'Tabla ' . $numero_table, 1, 1, 'C', true);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Courier', '', 10);

            $pdf->SetWidths([60, 130]);
            $pdf->Row(['Clave:', $cu->clave]);
            $pdf->Row(['Descripción:', $cu->descripcion]);

            $req_value = "";
            foreach ($cu->requerimientos as  $req) {
                $req_value .= $req['clave'] . " " . $req['descripcion'] . "\n\n";
            }

            $pdf->Row(['Requerimientos:', $req_value]);
            $pdf->Ln(10);
        }


        $pdf->AddPage();

        $pdf->SetFont('Courier', 'B', 12);
        $pdf->cell(190, 8, "Actores", 0, 1, 'L', false);
        $actores = Actor::where('proyecto', $proyecto->id)->get();

        $pdf->SetFont('Courier', '', 10);
        foreach ($actores as $key => $actor) {
            $numero_table += 1;
            $pdf->Ln(5);
            $pdf->cell(190, 5, utf8_decode($actor->nombre . " " . $actor->clave), 0, 1, 'C', false);
            $pdf->Ln(5);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Courier', 'B', 10);
            $pdf->cell(190, 5, 'Tabla ' . $numero_table, 1, 1, 'C', true);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Courier', '', 10);

            $pdf->SetWidths([60, 130]);
            $pdf->Row(['Clave:', $actor->clave]);
            $pdf->Row(['Nombre:', $actor->nombre]);
            $pdf->Row(['Descripción:', $actor->descripcion]);
            $pdf->Row(['Características:', $actor->caracteristicas]);
            $pdf->Row(['Relaciones:', $actor->relaciones]);
            $pdf->Row(['Responsabilidad:', $actor->responsabilidad]);
            $pdf->Row(['Actividades de entrada:', $actor->actividades_entrada]);
            $pdf->Row(['Actividades de salida:', $actor->actividades_salida]);
            $pdf->Ln(10);
        }


        // $pdf->Ln(10);
        $pdf->AddPage();
        $pdf->SetFont('Courier', 'B', 12);
        $pdf->cell(190, 8, "Artefactos", 0, 1, 'L', false);
        $artefactos = Artefacto::where('proyecto', $proyecto->id)->get();

        $pdf->SetFont('Courier', '', 10);

        foreach ($artefactos as $key => $artefacto) {
            $numero_table += 1;
            $pdf->Ln(5);
            $pdf->cell(190, 5, utf8_decode($artefacto->nombre . " " . $artefacto->clave), 0, 1, 'C', false);
            $pdf->Ln(5);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Courier', 'B', 10);
            $pdf->cell(190, 5, 'Tabla ' . $numero_table, 1, 1, 'C', true);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Courier', '', 10);

            $pdf->SetWidths([38, 152]);
            $pdf->Row(['Clave:', $artefacto->clave]);
            $pdf->Row(['Nombre:', $artefacto->nombre]);
            $pdf->Row(['Descripción:', $artefacto->descripcion]);
            $pdf->cell(190, 5, 'Datos', 1, 1, 'C', false);

            $pdf->SetFont('Courier', 'B', 10);
            $pdf->SetWidths([38, 38, 38, 38, 38]);
            $pdf->SetAligns(['C', 'C', 'C', 'C', 'C']);
            $pdf->Row(['Atributos:', 'Descripción', 'Tipo', 'Rango', 'Excepciones']);

            $data_artefactos = DataArtefacto::where('artefacto', $artefacto->id)->get();

            $pdf->SetFont('Courier', '', 10);
            $pdf->SetAligns(['L', 'L', 'L', 'L', 'L']);
            foreach ($data_artefactos as $data_arte) {
                $pdf->Row([
                    $data_arte->atributo,
                    $data_arte->descripcion,
                    $data_arte->tipo,
                    $data_arte->rango,
                    $data_arte->excepciones
                ]);
            }
            $pdf->Ln(10);
        }


        // $pdf->Ln(10);
        // $pdf->AddPage();
        $pdf->SetFont('Courier', 'B', 12);
        $pdf->cell(190, 8, "Procesos", 0, 1, 'L', false);
        $procesos = Proceso::where('proyecto', $proyecto->id)->get();
        foreach ($procesos as $proceso) {
            $pdf->AddPage();

            $numero_table += 1;
            $pdf->Ln(5);
            $pdf->cell(190, 5, utf8_decode($proceso->nombre), 0, 1, 'C', false);
            $pdf->Ln(5);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Courier', 'B', 10);
            $pdf->cell(190, 5, 'Tabla ' . $numero_table, 1, 1, 'C', true);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Courier', '', 10);

            $pdf->cell(190, 5, $proceso->nombre_plantilla, 1, 1, 'L', false);

            $path   = Storage::disk("public")->path('procesos/' . $proceso->image);



            $actor_proceso = ActoresProceso::where('proceso', $proceso->id)->get();

            $map_actores =  $actor_proceso->map(function ($proceso) {
                $actor_db = Actor::find($proceso->actor);
                return $actor_db->nombre;
            });

            $label_actores =  Arr::join($map_actores->toArray(), ', ');



            $pdf->SetWidths([38, 152]);
            $pdf->Row(['Nombre:', $proceso->nombre]);
            $pdf->Row(['Clave:', $proceso->descripcion]);
            $pdf->Row(['Actores:', $label_actores]);
            $pdf->Row(['Entrada:', $proceso->entrada]);

            $pdf->Image($path, 10, $pdf->getY() + 10, 190, 90);
        }



        // $pdf->row()
        // $pdf->Cell(50, 25, $proyecto->nombre, 1);

        $pdf->output();
        exit();
        // return $pdf->output('S');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyectos = Proyecto::get();
        return Inertia::render('Inicio', ['proyectos' => $proyectos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Proyectos/Nuevo');
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
            'nombre' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
        ]);

        $proyecto = new Proyecto();
        $proyecto->nombre = $request->nombre;
        $proyecto->responsable = $request->responsable;
        $proyecto->usuario = Auth::user()->id;
        $proyecto->save();

        return redirect('/proyectos');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function show(Proyecto $proyecto)
    {
        return Inertia::render('Proyectos/Visualizar', ['proyecto' => $proyecto]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function showEdit(Proyecto $proyecto)
    {
        return Inertia::render('Proyectos/Editar', ['proyecto' => $proyecto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyecto $proyecto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'numeric|required',
            'nombre' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
        ]);

        $proyecto = Proyecto::find($request->id);
        $proyecto->nombre = $request->nombre;
        $proyecto->responsable = $request->responsable;

        $proyecto->save();

        return redirect('/proyectos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyecto $proyecto)
    {
        $proyecto->delete();
    }
}
