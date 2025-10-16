<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Asistentes;
use BolsaTrabajo\Celula;
use BolsaTrabajo\Distrito;
use BolsaTrabajo\Asistencia;
use BolsaTrabajo\Seguimiento;
use BolsaTrabajo\Historial;
use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class AsistentesController extends Controller
{

    public function index()
    {
        // Obtén todas las células
        $celulas = Celula::where('estado', 1) // Solo estado 1
                 ->whereNull('deleted_at') // Excluir registros eliminados
                 ->get();
        $distritos = Distrito::where('provincia_id', 15)
                            ->orderBy('nombre')  // Ordenar alfabéticamente por nombre
                            ->get();
        // Pasar el objeto celulas a la vista
        return view('auth.asistentes.index', ['celulas' => $celulas, 'distritos' => $distritos]);
    }


    public function list_all()
    {
        // Eager load los nombres de Distrito y Celula
        $asistentes = Asistentes::with(['distrito', 'celula'])
            ->orderby('id', 'desc')
            ->get();

        // Mapear la colección para incluir los nombres
        $asistentes = $asistentes->map(function($asistente) {
            return [
                'id' => $asistente->id,
                'dni' => $asistente->dni,
                'nombre' => $asistente->nombre,
                'apellido' => $asistente->apellido,
                'fecha_nac' => $asistente->fecha_nac,
                'distrito_nombre' => $asistente->distrito ? $asistente->distrito->nombre : null,
                'direccion' => $asistente->direccion,
                'tel' => $asistente->tel,
                'genero' => $asistente->genero,
                'celula_id' => $asistente->celula_id,
                'celula_nombre' => $asistente->celula ? $asistente->celula->nombre : null,
                'estado' => $asistente->estado,
                'bautizado' => $asistente->bautizado,
                // Agrega otros campos según sea necesario
            ];
        });

        return response()->json(['data' => $asistentes]);
    }

    public function delete(Request $request)
    {
        $status = false;

        // Encuentra asistentes con el id proporcionado
        $event = Asistentes::find($request->id);

        if ($event) {
            // Verifica si hay asistentes activos asociados a la célula del evento
            $hasParticipants = Asistencia::where('asistente_id', $event->id)
                ->whereNull('deleted_at')
                ->exists();
            // Verifica si hay seguimientos activos asociados al asistente
            $hasFollowUps = Seguimiento::where('asistente_id', $event->id)
                ->whereNull('deleted_at')
                ->exists();

            if (!$hasParticipants && !$hasFollowUps) {
                if ($event->delete()) {
                    $status = true;
                } else {
                    // Error al intentar eliminar
                    return response()->json(['success' => $status, 'Message' => 'Error al intentar eliminar el asistente.']);
                }
            } else {
                // Mensaje específico si tiene registros asociados
                if ($hasParticipants) {
                    return response()->json(['success' => $status, 'Message' => 'No se puede eliminar el asistente porque tiene registros de asistencia asociados.']);
                }
                if ($hasFollowUps) {
                    return response()->json(['success' => $status, 'Message' => 'No se puede eliminar el asistente porque tiene seguimientos asociados.']);
                }
            }
        } else {
            // Asistentes no se encuentra
            return response()->json(['success' => $status, 'Message' => 'Asistente no encontrado.']);
        }

        return response()->json(['success' => $status]);
    }

    /* public function store(Request $request)
    {
        $status = false;
        $random = Str::upper(Str::random(4)); // Genera un string aleatorio en mayúsculas
        $foto = null;

        // Validación de los datos del formulario
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'distrito_id' => 'required|integer|exists:distritos,id',
            'genero' => 'required|string|max:20',
            'celula_id' => 'required|integer|exists:celulas,id',
        ]);

        if ($validator->fails()) {
            // Debugging validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Si se sube una foto, asigna un nombre único
        if ($request->file('foto') != null) {
            $foto = uniqid($random . "_") . '.' . $request->file('foto')->getClientOriginalExtension();
        }

        // Preparar los datos para crear el asistente
        $data = [
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'fecha_nac' => $request->input('fecha_nac'),
            'distrito_id' => $request->input('distrito_id'),
            'direccion' => $request->input('direccion'),
            'tel' => $request->input('tel'),
            'genero' => $request->input('genero'),
            'celula_id' => $request->input('celula_id'),
            'foto' => $foto ? 'uploads/fotos/' . $foto : null,
        ];
        try {
            Asistentes::create($data);

            if ($request->file('foto') != null) {
                $request->file('foto')->move(public_path('uploads/fotos'), $foto);
            }
            $status = true;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al registrar el asistente: ' . $e->getMessage());
        }

        // Redirigir con éxito o errores
        return redirect()->route('auth.asistentes')->with('success', 'Asistente registrado exitosamente.');
    } */


   

    public function store(Request $request)
    {
        $status = false;
        $random = Str::upper(Str::random(4)); // Genera un string aleatorio en mayúsculas
        $foto = null;

        // Validación de los datos del formulario
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'distrito_id' => 'required|integer|exists:distritos,id',
            'genero' => 'required|string|max:20',
            'celula_id' => 'required|integer|exists:celulas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Si se sube una foto, asigna un nombre único
        if ($request->file('foto') != null) {
            $foto = uniqid($random . "_") . '.' . $request->file('foto')->getClientOriginalExtension();
        }

        // Preparar los datos para crear el asistente
        $data = [
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'fecha_nac' => $request->input('fecha_nac'),
            'distrito_id' => $request->input('distrito_id'),
            'direccion' => $request->input('direccion'),
            'tel' => $request->input('tel'),
            'genero' => $request->input('genero'),
            'celula_id' => $request->input('celula_id'),
            'bautizado' => $request->input('bautizado', 0), // <--- aquí el cambio
            'foto' => $foto ? 'uploads/fotos/' . $foto : null,
        ];

        DB::beginTransaction(); // Inicia una transacción para ambas inserciones
        try {
            // Crear el asistente
            $asistente = Asistentes::create($data);

            // Registrar en otra tabla la relación con celula_id
            DB::table('historials')->insert([
                'asistente_id' => $asistente->id,
                'celula_id' => $request->input('celula_id'),
                'accion' => 'Registro de nuevo asistente', // Aquí registramos "nuevo" como acción
            ]);

            // Mover la foto a la carpeta de destino
            if ($request->file('foto') != null) {
                $request->file('foto')->move(public_path('uploads/fotos'), $foto);
            }

            DB::commit(); // Confirma las operaciones
            $status = true;
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte todo si ocurre un error
            return redirect()->back()->with('error', 'Error al registrar el asistente: ' . $e->getMessage());
        }

        // Redirigir con éxito
        return redirect()->route('auth.asistentes')->with('success', 'Asistente registrado exitosamente.');
    }


    public function partialView($id)
    {
        $entity = Asistentes::find($id);
    
        // Asegúrate de que la relación `distrito` esté cargada con el modelo `Asistentes`
        $distritos = Distrito::all(); // Obtener todos los distritos disponibles
        $celula = Celula::all(); 
        return view('auth.asistentes._Editar', [
            'Entity' => $entity,
            'distritos' => $distritos,'celulas' => $celula,
        ]);
    }

    /* public function update(Request $request)
    {
        $status = false;
        // Validar la solicitud
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:asistentes,id', // Verifica que el ID exista en la base de datos
            'foto' => 'nullable|mimes:jpg,jpeg,png|max:2048', // Validar la foto (opcional)
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Buscar el asistente
        $asistente = Asistentes::findOrFail($request->input('id'));

        // Actualizar los datos del asistente
        $asistente->nombre = $request->input('nombre');
        $asistente->apellido = $request->input('apellido');
        $asistente->fecha_nac = $request->input('fecha_nac');
        $asistente->distrito_id = $request->input('distrito_id');
        $asistente->direccion = $request->input('direccion');
        $asistente->tel = $request->input('tel');
        $asistente->genero = $request->input('genero');
        $asistente->celula_id = $request->input('celula_id');
        $asistente->estado = $request->input('estado');

        // Manejar la foto si se ha subido una nueva
        if ($request->hasFile('foto')) {
            // Eliminar la foto antigua si existe
            if ($asistente->foto && file_exists(public_path($asistente->foto))) {
                unlink(public_path($asistente->foto));
            }

            // Subir la nueva foto
            $file = $request->file('foto');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploads/fotos/';
            $file->move(public_path($filePath), $fileName);

            // Guardar la ruta de la nueva foto
            $asistente->foto = $filePath . $fileName;
        }

        // Guardar el asistente actualizado
        $asistente->save();
        if($asistente->save()) $status = true;    
        // Responder con éxito en formato JSON
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    } */

    

    public function update(Request $request)
    {
        $status = false;

        // Validar la solicitud
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:asistentes,id',
            'foto' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Buscar el asistente
        $asistente = Asistentes::findOrFail($request->input('id'));

        // Actualizar los datos del asistente
        $asistente->nombre = $request->input('nombre');
        $asistente->apellido = $request->input('apellido');
        $asistente->fecha_nac = $request->input('fecha_nac');
        $asistente->distrito_id = $request->input('distrito_id');
        $asistente->direccion = $request->input('direccion');
        $asistente->tel = $request->input('tel');
        $asistente->genero = $request->input('genero');
        $asistente->celula_id = $request->input('celula_id');
        $asistente->bautizado = $request->input('bautizado');
        $asistente->estado = $request->input('estado');

        // Manejar la foto si se sube una nueva
        if ($request->hasFile('foto')) {
            if ($asistente->foto && file_exists(public_path($asistente->foto))) {
                unlink(public_path($asistente->foto));
            }

            $file = $request->file('foto');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploads/fotos/';
            $file->move(public_path($filePath), $fileName);

            $asistente->foto = $filePath . $fileName;
        }

        // Guardar el asistente
        if ($asistente->save()) {
            $status = true;

            // Registrar en historial (asistente_id, celula_id y acción)
            Historial::create([
                'asistente_id' => $asistente->id,
                'celula_id' => $asistente->celula_id,
                'accion' => 'Actualización de asistente realizada', // Acción específica
            ]);
        }

        // Respuesta final
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    


    

    
}