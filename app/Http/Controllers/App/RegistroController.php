<?php

namespace BolsaTrabajo\Http\Controllers\App;

use BolsaTrabajo\User;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function index()
    {
        return view('app.registro.index');
    }

    public function store(Request $request)
    {
        $status = false;

        // Validaciones
        $validator = Validator::make($request->all(), [
            'pais' => 'required|string|max:100',
            'ecommerce' => 'required|string|max:150',
            'nombres' => 'required|string|max:150',
            'correo' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'user' => 'required|string|max:100|unique:users,usuario,NULL,id,deleted_at,NULL',
            'password' => 'required|string|min:6',
            'telefono' => 'required|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'Success' => $status,
                'Errors' => $validator->errors()
            ]);
        }

        $entity = new User();
        $entity->profile_id = 5;
        $entity->estado = 0; 
        $entity->pais = trim($request->pais);
        $entity->ecommerce_nombre = trim($request->ecommerce);
        $entity->nombres = trim($request->nombres);
        $entity->email = trim($request->correo);
        $entity->usuario = trim($request->user);
        $entity->telefono = trim($request->telefono);
        $entity->password = Hash::make($request->password);
        $entity->online = 0;
        $entity->inicio_sesion = null;
        $entity->cerrar_sesion = null;

        if ($entity->save()) {
            $status = true;
        }

        return response()->json([
            'Success' => $status,
            'Message' => $status ? 'Usuario registrado correctamente. Pendiente de aprobación.' : 'Error al registrar el usuario.'
        ]);
    }
    
}
