<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Seguimiento;
use BolsaTrabajo\Celula;
use BolsaTrabajo\Asistentes;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SeguimientoController extends Controller
{
    public function index()
    {
        $celula = Celula::where('estado', 1) // Solo estado 1
        ->whereNull('deleted_at') // Excluir registros eliminados
        ->get();

        $asistentes = Asistentes::where('estado', 1) // Solo estado 1
        ->whereNull('deleted_at') // Excluir registros eliminados
        ->get();


        return view('auth.seguimiento.index', compact('celula','asistentes'));
    }


    public function store(Request $request)
    {
        $status = false;
        
        // Validar los datos de la solicitud
        $validator = Validator::make($request->all(), [
            'asistente_id' => 'required|exists:asistentes,id', // Asegúrate de que el ID del usuario exista en la tabla `users`
        ]);
        
        // Verifica si la validación falla
        if (!$validator->fails()) {
            // Recolecta los datos para crear el nuevo registro
            $data = [
                'celula_id' => $request->celula_id, 
                'asistente_id' => $request->asistente_id, 
                'fecha_contacto' => $request->fecha_contacto,
                'tipo_contacto' => $request->tipo_contacto,
                'detalle' => $request->detalle,
                'oracion' => $request->oracion,
            ];

            // Crea el nuevo registro en la base de datos
            Seguimiento::create($data);
            $status = true;
        }

        // Redireccionar a la ruta del programa con un mensaje de éxito
        return redirect()->route('auth.seguimiento')->with('success', 'Seguimiento registrado exitosamente.');
    }
}
