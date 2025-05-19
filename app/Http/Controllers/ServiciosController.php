<?php

namespace App\Http\Controllers;

use App\Models\Servicios;
use App\Models\Section;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ServiciosController extends Controller
{
    public function index(Request $request) {

        if (!empty($request->records_per_page)) {

            $request->records_per_page = $request->records_per_page <= env('PAGINATION_MAX_SIZE') ? $request->records_per_page
                                                                                                  : env('PAGINATION_MAX_SIZE');
        } else {

            $request->records_per_page = env('PAGINATION_DEFAULT_SIZE');
        }

        $servicios = Servicios::with('section')
                     ->where('title', 'LIKE', "%$request->filter%")
                     ->paginate($request->records_per_page);

        return view('servicios/index', [ 'servicios' => $servicios, 'data' => $request ]);
    }

    public function create() {

        $sections = Section::all();
        return view('servicios/create', [ 'sections' => $sections ]);
    }

    public function store(Request $request) {

        Validator::make($request->all(), [
            'title' => 'required|max:64',
            'description' => 'required',
            'section_id' => 'required|exists:sections,id',
        ], [
            'title.required' => 'El nombre es requerido.',
            'title.max' => 'El nombre no puede ser mayor a :max carácteres.',

            'description.required' => 'La descripción es requerida.',

            'section_id.required' => 'La sección es requerida.',
            'section_id.exists' => 'El id dado para la sección no existe.',
        ])->validate();

        try {

            $servicios = new Servicios();
            $servicios->title = $request->title;
            $servicios->description = $request->description;
            $servicios->section_id = $request->section_id;
            $servicios->save();

            Session::flash('message', ['content' => 'Servicio creado con éxito', 'type' => 'success']);

            return redirect()->action([ServiciosController::class, 'index']);

        } catch(\Exception $ex){

            Log::error($ex);
            Session::flash('message', ['content' => 'Ha ocurrido un error', 'type' => 'error']);
            return redirect()->back();
        }
    }

    public function edit($id) {

        $servicios = Servicios::find($id);

        if (empty($servicios)) {

            Session::flash('message', ['content' => "El Servicio con id: '$id' no existe.", 'type' => 'error']);
            return redirect()->back();
        }

        $sections = Section::all();

        return view('servicios/edit', [
            'servicios' => $servicios,
            'sections' => $sections
        ]);
    }

    public function update(Request $request) {

        Validator::make($request->all(), [
            'title' => 'required|max:64',
            'description' => 'required',
            'section_id' => 'required|exists:sections,id',
            'servicios_id' => 'required|exists:servicios,id',
        ], [
            'title.required' => 'El nombre es requerido.',
            'title.max' => 'El nombre no puede ser mayor a :max carácteres.',

            'description.required' => 'La descripción es requerida.',

            'section_id.required' => 'La sección es requerida.',
            'section_id.exists' => 'El id dado para la sección no existe.',

            'servicios_id.required' => 'El servicio es requerido.',
            'servicios_id.exists' => 'El id dado para el servicio no existe.',
        ])->validate();

        try {

            $servicios = Servicios::find($request->servicios_id);
            $servicios->title = $request->title;
            $servicios->description = $request->description;
            $servicios->section_id = $request->section_id;
            $servicios->save();

            Session::flash('message', ['content' => 'Servicio actualizado con éxito', 'type' => 'success']);

            return redirect()->action([ServiciosController::class, 'index']);

        } catch(\Exception $ex){

            Log::error($ex);
            Session::flash('message', ['content' => 'Ha ocurrido un error', 'type' => 'error']);
            return redirect()->back();
        }
    }

    public function delete($id) {

        try {

            $servicios = Servicios::find($id);

            if (empty($servicios)) {

                Session::flash('message', ['content' => "El servicio con id: '$id' no existe.", 'type' => 'error']);
                return redirect()->back();
            }

            $servicios->delete();

            Session::flash('message', ['content' => 'Servicio eliminado con éxito', 'type' => 'success']);
            return redirect()->action([ServiciosController::class, 'index']);

        } catch(Exception $ex){

            Log::error($ex);
            Session::flash('message', ['content' => 'Ha ocurrido un error', 'type' => 'error']);
            return redirect()->back();
        }
    }
}
