<?php

namespace App\Http\Controllers;

use App\Models\Servicios;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ServiciosController extends Controller
{
    // Método para mostrar los servicios con paginación
    public function index(Request $request)
    {
        // Validación del número de registros por página
        if (!empty($request->records_per_page)) {
            $request->records_per_page = $request->records_per_page <= env('PAGINATION_MAX_SIZE') ? $request->records_per_page
                : env('PAGINATION_MAX_SIZE');
        } else {
            $request->records_per_page = env('PAGINATION_DEFAULT_SIZE');
        }

        // Obtener los servicios filtrados y paginados
        $servicios = Servicios::with('section')
            ->where('title', 'LIKE', "%$request->filter%")
            ->paginate($request->records_per_page);

        return view('servicios.index', ['servicios' => $servicios, 'data' => $request]);
    }

    // Método para mostrar el formulario de creación
    public function create()
    {
        $sections = Section::all();
        return view('servicios.create', ['sections' => $sections]);
    }

    // Método para almacenar un servicio nuevo
    public function store(Request $request)
    {
        // Validación
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
            // Crear el servicio
            $servicios = new Servicios();
            $servicios->title = $request->title;
            $servicios->description = $request->description;
            $servicios->section_id = $request->section_id;
            $servicios->save();

            Session::flash('message', ['content' => 'Servicio creado con éxito', 'type' => 'success']);
            return redirect()->action([ServiciosController::class, 'index']);
        } catch (\Exception $ex) {
            Log::error($ex);
            Session::flash('message', ['content' => 'Ha ocurrido un error', 'type' => 'error']);
            return redirect()->back();
        }
    }

    // Método para mostrar el formulario de edición
    public function edit($id)
    {
        $servicios = Servicios::find($id);

        if (!$servicios) {
            Session::flash('message', ['content' => "El servicio con id: '$id' no existe.", 'type' => 'error']);
            return redirect()->back();
        }

        $sections = Section::all();
        return view('servicios.edit', ['servicios' => $servicios, 'sections' => $sections]);
    }

    // Método para actualizar el servicio
    public function update(Request $request, $id)
    {
        // Validación
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
            // Buscar el servicio
            $servicios = Servicios::find($id);

            if (!$servicios) {
                Session::flash('message', ['content' => "El servicio con id: '$id' no existe.", 'type' => 'error']);
                return redirect()->back();
            }

            // Actualizar los campos
            $servicios->title = $request->title;
            $servicios->description = $request->description;
            $servicios->section_id = $request->section_id;
            $servicios->save();

            Session::flash('message', ['content' => 'Servicio actualizado con éxito', 'type' => 'success']);
            return redirect()->action([ServiciosController::class, 'index']);
        } catch (\Exception $ex) {
            Log::error($ex);
            Session::flash('message', ['content' => 'Ha ocurrido un error', 'type' => 'error']);
            return redirect()->back();
        }
    }

    // Método para eliminar un servicio
    public function delete($id)
    {
        try {
            $servicios = Servicios::find($id);

            if (!$servicios) {
                Session::flash('message', ['content' => "El servicio con id: '$id' no existe.", 'type' => 'error']);
                return redirect()->back();
            }

            $servicios->delete();

            Session::flash('message', ['content' => 'Servicio eliminado con éxito', 'type' => 'success']);
            return redirect()->action([ServiciosController::class, 'index']);
        } catch (\Exception $ex) {
            Log::error($ex);
            Session::flash('message', ['content' => 'Ha ocurrido un error', 'type' => 'error']);
            return redirect()->back();
        }
    }
}

