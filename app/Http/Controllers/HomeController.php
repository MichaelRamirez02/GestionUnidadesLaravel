<?php

namespace App\Http\Controllers;

use App\Helpers\RoleHelper;
use App\Models\Servicios;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $sections = Section::select('sections.id', 'sections.name');

        // if (!RoleHelper::currentUserIsAdmin())   {
        //     $user = Auth::user();

        //     $sections = $sections->join('role_sections', 'sections.id', '=', 'role_sections.section_id')
        //                          ->where('role_sections.role_id', '=', $user->role_id);
        // }

        $sections = $sections->get();

        return view('home.index', ['sections' => $sections]);
    }

    public function section($id)
    {
        $section = Section::with('servicios')->find($id);

        if (!$section) {
            Session::flash('message', [
                'content' => "La sección con ID '$id' no existe.",
                'type' => 'error'
            ]);
            return redirect()->back();
        }

        return view('home.section', ['section' => $section]);
    }

    public function servicios($id)
    {
        $servicios = Servicios::find($id);

        if (!$servicios) {
            Session::flash('message', [
                'content' => "El servicio con ID '$id' no existe.",
                'type' => 'error'
            ]);
            return redirect()->back();
        }

        return view('home.servicios', ['servicios' => $servicios]);
    }
}

