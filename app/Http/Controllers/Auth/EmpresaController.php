<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Empresa;
use BolsaTrabajo\Aviso;
use BolsaTrabajo\Asistentes;
use BolsaTrabajo\Calendario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use BolsaTrabajo\Http\Controllers\Controller;

class EmpresaController extends Controller
{
    public function index()
    {   
        if (Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_TIMOTEO) {
            return view('auth.empresa.index');
        } // Opcionalmente, podrías manejar el caso en que la condición no se cumple
        return redirect('/auth/inicio'); // Redirige a una página predeterminada si la condición no se cumple
    }

    /* OLD */
    public function list(Request $request)
    {
        if($request->mostrar == 'mostrar'){
            return response()->json(['data' => Empresa::with('provincias')
            ->with('distritos')
            ->with('actividad_economicas')
            ->orderBy('created_at', 'DESC')
            ->get() ]);
        }else if($request->ruc_dni != null && $request->ruc_dni != ""){
            return response()->json(['data' => Empresa::with('provincias')
            ->where('tipo_persona', 'like', '%'.$request->actividad_eco_filter_id.'%' )
            ->where('ruc', 'like', '%'.$request->ruc_dni.'%' )
            ->orWhere('nombre_comercial', 'like', '%'.$request->ruc_dni.'%')
            ->with('distritos')
            ->with('actividad_economicas')
            ->orderBy('created_at', 'DESC')
            ->limit(80)
            ->get() ]);
        }else if($request->ruc_dni == "" && $request->actividad_eco_filter_id != ""){
            return response()->json(['data' => Empresa::with('provincias')
            ->where('tipo_persona', 'like', '%'.$request->actividad_eco_filter_id.'%' )
            ->whereBetween('created_at', [$request->fecha_desde , $request->fecha_hasta])
            ->with('distritos')
            ->with('actividad_economicas')
            ->orderBy('created_at', 'DESC')
            ->get() ]);
        }else if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {
            return response()->json(['data' => Empresa::with('provincias')
            ->where('tipo_persona', 'like', '%'.$request->actividad_eco_filter_id.'%' )
            ->whereBetween('created_at', [$request->fecha_desde , $request->fecha_hasta])
            ->with('distritos')
            ->with('actividad_economicas')
            ->orderBy('created_at', 'DESC')
            ->get() ]);
        }else{
            return response()->json(['data' => '' ]);
        }
    }


    public function notification()
    {
        $now = now();
        $threeDaysLater = $now->copy()->addDays(3);
        $dates = [
            $now->toDateString(), // Hoy
            $now->copy()->addDays(1)->toDateString(), // 1 día
            $now->copy()->addDays(2)->toDateString(), // 2 días
            $now->copy()->addDays(3)->toDateString(), // 3 días
        ];
    
        // Consultar asistentes con cumpleaños en los próximos 5 días, incluyendo hoy
        $birthdayNotices = [];
        for ($i = 0; $i <= 5; $i++) {
            $targetDate = $now->copy()->addDays($i);
    
            $notices = Asistentes::whereMonth('fecha_nac', $targetDate->month)
                ->whereDay('fecha_nac', $targetDate->day)
                ->get();
    
            if ($notices->isNotEmpty()) {
                $birthdayNotices[$i] = $notices;
            }
        }
    
        // Consultar eventos en el calendario que ocurren en los próximos 3 días, incluyendo hoy
        $eventsNotices = Calendario::whereIn('fecha_registro', $dates)
            ->get();
    
        return response()->json([
            'birthdayNotices' => $birthdayNotices,
            'eventsNotices' => $eventsNotices
        ]);
    }
    



    public function partialView($id)
    {
        return view('auth.empresa._Mantenimiento', ['Entity' => Empresa::find($id)]);
    }

    public function update(Request $request)
    {
        $status = false;
        $entity = Empresa::find($request->id);
        $entity->aprobado = $request->update_id;

        if($entity->save()) $status = true;

        return response()->json(['Success' => $status]);
    }

    public function updateData(Request $request)
    {
        $status = false;
        $validator = Validator::make($request->all(), [
            'tipo_persona' => 'required',
        ]);
        if (!$validator->fails()){
            $entity = Empresa::find($request->id);
            $entity->tipo_persona = $request->tipo_persona;
            $entity->ruc = $request->ruc;
            $entity->razon_social = $request->razon_social;
            $entity->nombre_comercial = $request->nombre_empresa;
            $entity->direccion = $request->direccion;
            $entity->telefono = $request->telefono;
            $entity->email = $request->email;
            $entity->pagina_web = $request->pagina_Web;
            $entity->nombre_contacto = $request->nombre_contacto;
            $entity->telefono_contacto = $request->telefono_contacto;
            $entity->cargo_contacto = $request->cargo_contacto;
            $entity->email_contacto = $request->email_contacto;
            if($entity->save()) $status = true;            
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    /* public function delete(Request $request)
    {
        $status = false;
        $entity = Empresa::find($request->id);
        if($entity->delete()) $status = true;

        return response()->json(['Success' => $status]);
    } */

    public function delete(Request $request)
    {
        $status = false;
    
        // Encuentra la entidad Empresa por ID, incluyendo los registros eliminados
        $entity = Empresa::withTrashed()->find($request->id);
    
        // Verifica si la entidad existe
        if ($entity) {
            // Si la empresa ya está eliminada lógicamente (soft deleted)
            if ($entity->deleted_at !== null) {
                // Permite eliminarla de manera definitiva
                if ($entity->forceDelete()) {
                    $status = true;
                }
            } else {
                // Verifica si hay registros en la tabla 'avisos' con el 'empresa_id' correspondiente
                $hasAvisos = Aviso::where('empresa_id', $request->id)->exists();
    
                // Si no hay avisos asociados, elimina la empresa lógicamente
                if (!$hasAvisos) {
                    if ($entity->delete()) {
                        $status = true;
                    }
                } else {
                    // Si hay avisos asociados, devuelve un mensaje de error
                    return response()->json(['Success' => $status, 'Message' => 'No se puede eliminar la empresa porque tiene avisos asociados.']);
                }
            }
        } else {
            // Si la entidad no existe, devuelve un mensaje de error
            return response()->json(['Success' => $status, 'Message' => 'La empresa no existe.']);
        }
    
        // Devuelve la respuesta en formato JSON
        return response()->json(['Success' => $status]);
    }
    
    


}