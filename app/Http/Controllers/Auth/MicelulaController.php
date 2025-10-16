<?php

namespace BolsaTrabajo\Http\Controllers\Auth;


use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use BolsaTrabajo\Historial;
use BolsaTrabajo\Asistentes;
use BolsaTrabajo\Celula;


class MicelulaController extends Controller
{

    
    public function index()
    {
        $user = Auth::guard('web')->user(); // Usuario autenticado
        $celulas = Celula::where('lider_id', $user->id)->get(); // Obtener todas las células del líder

        if ($celulas->isEmpty()) {
            return redirect()->back()->with('error', 'No tienes una célula asignada.');
        }

        // Obtener los asistentes de todas las células que lidera el usuario
        $asistentes = Asistentes::where('estado', 1)
                    ->whereIn('celula_id', $celulas->pluck('id')) // Filtrar por todas las células del líder
                    ->orderBy('nombre', 'asc')
                    ->get();

        return view('auth.micelula.index', compact('celulas', 'asistentes'));
    }

}