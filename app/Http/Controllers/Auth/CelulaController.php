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

class CelulaController extends Controller
{

    public function index()
    {
        $users = User::where('estado', 1)->get();
        return view('auth.celula.index', ['user' => $users]);
    }

      

    public function list_all()
    {
        // Obtener todas las instancias de Celula con la relación lider cargada
        $celulas = Celula::with('lider')->orderby('id', 'desc')->get();

        // Formatear la respuesta para incluir el nombre del líder
        $data = $celulas->map(function ($celula) {
            return [
                'id' => $celula->id, // Campo 'nombre' de Celula
                'nombre' => $celula->nombre, // Campo 'nombre' de Celula
                'nombrelider' => $celula->lider ? $celula->lider->nombres : 'Sin líder', // Campo 'name' de User
                'descripcion' => $celula->descripcion, // Campo 'descripcion' de Celula
                'estado' => $celula->estado, // Campo 'descripcion' de Celula
            ];
        });

        // Devolver la respuesta en formato JSON
        return response()->json(['data' => $data]);
    }
    public function store(Request $request)
    {
        $status = false;
        
        // Validar los datos de la solicitud
        $validator = Validator::make($request->all(), [
            'lider_id' => 'required|exists:users,id', // Asegúrate de que el ID del usuario exista en la tabla `users`
            'nombre' => 'required|string|max:255',
        ]);
        
        // Verifica si la validación falla
        if (!$validator->fails()) {
            // Recolecta los datos para crear el nuevo registro
            $data = [
                'lider_id' => $request->lider_id, // Usa `liderid` aquí
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                
            ];

            // Crea el nuevo registro en la base de datos
            Celula::create($data);
            $status = true;
        }

        // Redireccionar a la ruta del programa con un mensaje de éxito
        return redirect()->route('auth.celula')->with('success', 'Celula registrada exitosamente.');
    }


    //ELIMINAR CELULA
    public function delete(Request $request)
    {
        $status = false;

        // Encuentra el evento con el id proporcionado
        $event = Celula::find($request->id);

        if ($event) {
            // Verifica si hay asistentes asociados a la célula del evento
            $hasParticipants = Asistentes::where('celula_id', $event->id)->exists();

            if (!$hasParticipants) {
                // Elimina el evento si no tiene asistentes asociados
                if ($event->delete()) {
                    $status = true;
                } else {
                    // Error al intentar eliminar
                    return response()->json(['Success' => $status, 'Message' => 'Error al intentar eliminar la celula.']);
                }
            } else {
                // El evento tiene asistentes asociados
                return response()->json(['Success' => $status, 'Message' => 'No se puede eliminar la celula porque tiene asistentes asociados.']);
            }
        } else {
            // El evento no se encuentra
            return response()->json(['Success' => $status, 'Message' => 'Celula no encontrado.']);
        }

        return response()->json(['Success' => $status]);
    }

    public function partialViewAsistentes($id)
    {
        // Asegúrate de que el ID es válido y que la entidad se encuentra en la base de datos
        $entity = Celula::find($id);
        // Pasar la entidad a la vista
        return view('auth.celula.listadoasistentes', ['Entity' => $entity]);
    }

    /* Mostrar Asistentes en Tabla al momento de abrir el modal LISTADO TABLA*/
    public function mostrarAsistentes(Request $request)
    {
        $celula_id = $request->input('celula_id');
    
        // Consulta usando el modelo Eloquent
        $asistentes = Asistentes::join('celulas as c', 'asistentes.celula_id', '=', 'c.id') // Unir con la tabla de células
                                ->join('distritos as d', 'asistentes.distrito_id', '=', 'd.id') // Unir con la tabla de distritos
                                ->select('asistentes.dni', 'asistentes.nombre', 'asistentes.apellido',
                                        'asistentes.fecha_nac', 'asistentes.direccion', 'asistentes.tel', 'asistentes.genero', 'asistentes.id',
                                        'd.nombre as distrito') // Seleccionar el nombre del distrito
                                ->where('c.id', $celula_id) // Filtrar por el id de la célula
                                ->where('asistentes.estado', 1) // Filtrar por asistentes activos
                                ->orderBy('asistentes.created_at', 'DESC') // Ordenar por la fecha de creación
                                ->get();
    
        return response()->json(['data' => $asistentes]);
    }
    


    /* EDITAR 1 */     
    public function modalSeguimientoAsistentes($id)
    {
        // Asegúrate de que el ID es válido y que la entidad se encuentra en la base de datos
        $entity = Asistentes::find($id);
        // Pasar la entidad a la vista
        return view('auth.celula.seguimiento', ['Entity' => $entity]);
    }

    public function listSeguimiento(Request $request)
    {
        $asistenteId = $request->input('asistente_id');
        
        $seguimientos = DB::table('seguimiento as s')
                        ->select('s.id', 's.asistente_id', 's.fecha_contacto', 's.tipo_contacto', 
                                's.detalle', 's.oracion')
                        ->where('s.asistente_id', $asistenteId)
                        ->whereNull('s.deleted_at')
                        ->orderBy('s.fecha_contacto', 'asc')
                        ->get();
        
        return response()->json(['data' => $seguimientos]);
    }


    /* EDITAR CELULA */

    public function partialView($id)
    {
        $entity = Celula::find($id);
        $users = User::all();
        
        return view('auth.celula.Editar', ['Entity' => $entity, 'users' => $users]);
    }


    public function update(Request $request)
    {
        $status = false;
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if (!$validator->fails()){
            $entity = Celula::find($request->id);
            $entity->lider_id = $request->lider_id;
            $entity->nombre = $request->nombre;
            $entity->descripcion = $request->descripcion;
            $entity->estado = $request->estado;

            if($entity->save()) $status = true;            
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    /* GUARDAR SEGUIMIENTO */
    public function storeSeguimiento(Request $request)
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
                'descripcion' => $request->descripcion,
                'detalle' => $request->detalle,
                'oracion' => $request->oracion,
            ];

            // Crea el nuevo registro en la base de datos
            Seguimiento::create($data);
            $status = true;
        }

        // Redireccionar a la ruta del programa con un mensaje de éxito
        return redirect()->route('auth.celula')->with('success', 'Seguimiento registrado exitosamente.');
    }
}