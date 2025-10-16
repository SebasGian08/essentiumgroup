<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Celula;
use BolsaTrabajo\Asistentes;
use BolsaTrabajo\Seguimiento;
use BolsaTrabajo\User;
use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AsistenciaReporteController extends Controller
{

    public function index()
    {
    $celulas = Celula::where('estado', 1)->whereNull('deleted_at')->get();
      return view('auth.asistenciareporte.index', compact('celulas'));
    }

    public function getReporte(Request $request)
    {
        $celulas = $request->input('celulas');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        // Llamar al Stored Procedure
        $reporte = DB::select("CALL sp_reporte_asistencia(?, ?, ?)", [
            $celulas,
            $fecha_inicio,
            $fecha_fin
        ]);

        return response()->json($reporte);
    }
    
}