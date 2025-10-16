<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Programa;
use BolsaTrabajo\Participantes;
use BolsaTrabajo\Cargo;
use BolsaTrabajo\Condicion;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProgramaController extends Controller
{
    public function index()

    {   
        if (Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_DESARROLLADOR) {

        return view('auth.programa.index');

        }   
        
        return redirect('/auth/inicio'); 
        
    }


    public function listAll()
{
    $programas = Programa::select(
            'programas.id',
            'programas.registro',
            'programas.tipo_programa',
            'programas.empresa',
            'programas.puestouno',
            'programas.puestodos',
            'programas.puestotres',
            'programas.puestocuatro',
            'programas.responsable',
            DB::raw('COUNT(CASE WHEN participantes.estado = "Postulante" AND participantes.deleted_at IS NULL THEN 1 END) AS cantidad_postulantes'),
            DB::raw('COUNT(CASE WHEN participantes.estado = "Evaluando" AND participantes.deleted_at IS NULL THEN 1 END) AS cantidad_evaluando'),
            DB::raw('COUNT(CASE WHEN participantes.estado = "Contratado" AND participantes.deleted_at IS NULL THEN 1 END) AS cantidad_contratados'),
            DB::raw('COUNT(CASE WHEN participantes.estado = "Descartado" AND participantes.deleted_at IS NULL THEN 1 END) AS cantidad_descartados')
        )
        ->leftJoin('participantes', function ($join) {
            $join->on('programas.id', '=', 'participantes.id_programa')
                 ->whereNull('participantes.deleted_at'); /* Para no contar los participantes eliminados */
        })
        ->whereNull('programas.deleted_at') // Filtrar programas eliminados si usas soft delete
        ->groupBy(
            'programas.id',
            'programas.registro',
            'programas.tipo_programa',
            'programas.empresa',
            'programas.puestouno',
            'programas.puestodos',
            'programas.puestotres',
            'programas.puestocuatro',
            'programas.responsable'
        )
        ->orderBy('programas.registro', 'desc') // Ordenar por la fecha más reciente a la más antigua
        ->get();

    return response()->json(['data' => $programas]);
}




public function delete(Request $request)
{
    $status = false;
    
    // Encuentra el programa con el id proporcionado
    $entity = Programa::find($request->id);

    if ($entity) {
        // Verifica si hay participantes asociados al programa
        $hasParticipants = $entity->Participantes()->exists();

        if (!$hasParticipants) {
            // Elimina el programa si no tiene participantes asociados
            if ($entity->delete()) {
                $status = true;
            }
        } else {
            // Puedes devolver un mensaje de error si el programa tiene participantes
            return response()->json(['Success' => $status, 'Message' => 'No se puede eliminar el programa porque tiene participantes asociados.']);
        }
    } else {
        // Devuelve un mensaje de error si el programa no se encuentra
        return response()->json(['Success' => $status, 'Message' => 'Programa no encontrado.']);
    }

    return response()->json(['Success' => $status]);
}


    

    public function store(Request $request)
    {
        $status = false;
        
        // Validación de los datos enviados
        $validator = Validator::make($request->all(), [
            'registro' => 'required',
            'tipo_programa' => 'required',
            'empresa' => 'required',
            'puestouno' => 'required',
            'responsable' => 'required',
        ]);
        

        // Verifica si la validación ha fallado
        if (!$validator->fails()) {
            // Si la validación es exitosa, prepara los datos para la creación del programa
            $data = [
                /* datos del programa */
                'registro' => $request->registro,
                'tipo_programa' => $request->tipo_programa,
                'empresa' => $request->empresa,
                'puestouno' => $request->puestouno,
                'puestodos' => $request->puestodos,
                'puestotres' => $request->puestotres,
                'puestocuatro' => $request->puestocuatro,
                'responsable' => $request->responsable,
                /* datos adicionales */
                /* 'postulantes' => $request->postulantes,
                'evaluando' => $request->evaluando,
                'contratados' => $request->contratados,
                'descartado' => $request->descartado, */               
            ];
            // Crea el programa en la base de datos
            Programa::create($data);
    
            $status = true;
        }
        return $status ? redirect(route('auth.programa')) : redirect(route('auth.programa'))->withErrors($validator)->withInput();

    }

    public function partialView($id)
    {

        return view('auth.programa.Mantenimiento', ['Entity' => Programa::find($id)]);
    }

    public function updateData(Request $request)
    {
        $status = false;
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if (!$validator->fails()){
            $entity = Programa::find($request->id);
            $entity->registro = $request->registro;
            $entity->tipo_programa = $request->tipo_programa;
            $entity->empresa = $request->empresa;
            $entity->puestouno = $request->puestouno;
            $entity->puestodos = $request->puestodos;
            $entity->puestotres = $request->puestotres;
            $entity->puestocuatro = $request->puestocuatro;
            $entity->responsable = $request->responsable;

            /* Otros datos cantidad */
            /* $entity->postulantes = $request->postulantes;
            $entity->evaluando = $request->evaluando;
            $entity->contratados = $request->contratados;
            $entity->descartado = $request->descartado; */


            /* datos del estudiante  */
            /* $entity->dni = $request->dni;
            $entity->nombres = $request->nombres;
            $entity->apellidos = $request->apellidos;
            $entity->tel = $request->tel;
            $entity->email = $request->email;
            $entity->estado = $request->estado;
            $entity->tipo = $request->tipo;
            $entity->sede = $request->sede; */


            if($entity->save()) $status = true;            
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    /* Para que se muestre los datos  en Participantes*/
    /* Hay posibilidad para listar en participantes */
    public function partialViewParticipantes($id)
    {
        return view('auth.programa.Participantes', ['Entity' => Programa::find($id)]);
    }


    public function storeParticipantes(Request $request)
    {
        // Validación de los datos enviados
        $validator = Validator::make($request->all(), [
            'dni' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'especialidad' => 'required',
            'tipo' => 'required',
            'estado' => 'required',
            'sede' => 'required',
        ]);
    
        // Verifica si la validación ha fallado
        if ($validator->fails()) {
            return response()->json(['Success' => false, 'error' => $validator->errors()], 400);
        }
    
        // Verificar si ya existe un participante con el mismo DNI en el mismo programa y que no esté eliminado
            $existingParticipant = Participantes::where('id_programa', $request->id_programa)
            ->where('dni', $request->dni)
            ->whereNull('deleted_at') // Asumiendo que usas soft deletes y 'deleted_at' es la columna de eliminación
            ->first();
    
        if ($existingParticipant) {
            return response()->json(['Success' => false, 'Message' => 'Ya existe un participante con DNI ' . $request->dni . ' en este programa']);
        }
    
        // Si no existe, procede a crear el participante
        try {
            $data = [
                'id_programa' => $request->id_programa,
                'dni' => $request->dni,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'especialidad' => $request->especialidad,
                'tel' => $request->tel,
                'email' => $request->email,
                'estado' => $request->estado,
                'tipo' => $request->tipo,
                'sede' => $request->sede,
            ];
    
            Participantes::create($data);
    
            return response()->json(['Success' => true, 'message' => 'Participante creado correctamente'], 200);
            
        } catch (\Exception $e) {
            return response()->json(['Success' => false, 'error' => 'Error al crear el Participante: ' . $e->getMessage()], 500);
        }
    }

    public function mostrarParticipantes(Request $request)
    {
        $id_programa = $request->input('id_programa');
        $participantes = DB::table('participantes as p')
                        ->join('programas as pr', 'p.id_programa', '=', 'pr.id')
                        ->select('p.id_participante','p.email', 'p.especialidad','pr.registro','p.sede', 'pr.tipo_programa', 'p.nombres', 'p.dni', 'p.apellidos','p.tel', 'p.tipo', 'p.estado')
                        ->where('pr.id', $id_programa)
                        ->whereNull('p.deleted_at')
                        ->orderBy('p.created_at', 'DESC')
                        ->get();
        /* dump($participantes); */
        return response()->json(['data' => $participantes]);
    }
    
    public function deletepar(Request $request)
    {
        $status = false;
    
        $entity = Participantes::find($request->id);
    
        if ($entity && $entity->delete()) {
            $status = true;
        }
    
        return response()->json(['Success' => $status]);
    }



    public function partialViewpar($id)
    {
        return view('auth.programa.ParticipantesEdit', ['Entity' => Participantes::find($id)]);

    }
    
    public function updateParticipanteInscrito(Request $request)
    {
        $status = false;
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if (!$validator->fails()){
            $entity = Participantes::find($request->id);
            $entity->especialidad = $request->especialidadEdit;
            $entity->tel = $request->telefonoEdit;
            $entity->email = $request->email;

            if($entity->save()) $status = true;            
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

}