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


class ReasignarController extends Controller
{

   /*  public function index()
    {
            return view('auth.reasignar.index');
        
    } */

    public function index()
    {
        $celulas = Celula::where('estado', 1) // Solo estado 1
                 ->whereNull('deleted_at') // Excluir registros eliminados
                 ->orderBy('nombre', 'asc')
                 ->get();
        $asistentes = Asistentes::where('estado', 1)
                 ->orderBy('nombre', 'asc')
                 ->get()
                 ->groupBy('celula_id');
             
        $User = Auth::guard('web')->user();
        $userId = $User->id; // Extraer el ID del usuario         
        return view('auth.reasignar.index', compact('celulas','asistentes','userId'));
    }


    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'asistente_id' => 'required|array', // Array de asistentes seleccionados
            'asistente_id.*' => 'exists:asistentes,id', // Verificar que los ID existen
            'celula_id' => 'required|exists:celulas,id', // Verificar que la nueva célula existe
            'id_user' => 'required|exists:users,id', // Verificar que el id_user existe en la tabla users
        ]);
    
        // Obtener el ID del usuario si es necesario (si no se pasa en la solicitud, usaremos el autenticado)
        $idUser = $request->id_user ?? auth()->user()->id; // Usamos el ID del usuario autenticado si no se pasa
    
        // Obtener la nueva célula seleccionada
        $nuevaCelula = Celula::find($request->celula_id);
    
        // Reasignar cada asistente a la nueva célula
        foreach ($request->asistente_id as $asistenteId) {
            // Obtener el asistente actual
            $asistente = Asistentes::find($asistenteId);
            
            // Registrar el historial con la nueva célula
            Historial::create([
                'asistente_id' => $asistente->id,
                'celula_id' => $nuevaCelula->id, // Nueva célula
                'fecha_inicio' => now(), // Fecha del cambio
                'accion' => 'Reasignacion de forma masiva',
                'user_id' => $idUser, // ID del usuario (que se pasa o se obtiene de la autenticación)
            ]);
    
            // Actualizar el asistente con la nueva célula
            $asistente->celula_id = $nuevaCelula->id;
            $asistente->save();
        }
    
        // Redirigir a una página de éxito
        return redirect()->route('auth.reasignar')
                         ->with('success', 'Asistentes reasignados correctamente.');
    }
    

    
}