<?php

namespace BolsaTrabajo\Http\Controllers\App;

use BolsaTrabajo\Aniversario;
use BolsaTrabajo\Celula;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AniversarioController extends Controller
{


    public function index()
    {
        $celulas = Celula::where('estado', 1) // Solo estado 1
                 ->whereNull('deleted_at') // Excluir registros eliminados
                 ->get();
        return view('app.aniversario.index',['celulas' => $celulas]); // Asegúrate de que la ruta sea correcta
    }


    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tel' => 'required|string|max:15',
            'foto' => 'nullable|image|max:2048', // Validar que la foto es una imagen opcional
        ]);
    
        // Generar un string aleatorio para el nombre del archivo
        $random = Str::upper(Str::random(4));
        $fotoPath = null;
    
        // Manejar la carga de la foto
        if ($request->file('foto')) {
            $foto = uniqid($random . "_") . '.' . $request->file('foto')->getClientOriginalExtension();
            $fotoPath = 'uploads/fotos/' . $foto; // Construir la ruta
    
            // Mover la foto al directorio adecuado
            $request->file('foto')->move(public_path('uploads/fotos'), $foto);
        }
    
        // Preparar los datos para guardar
        $data = [
            'nombre' => $request->input('nombre'),
            'celula_id' => $request->input('celula_id'),
            'tel' => $request->input('tel'),
            'foto' => $fotoPath, // Asignar la ruta de la foto
        ];
    
        // Crear una nueva instancia del modelo
        $aniversario = new Aniversario(); // Asegúrate de que el modelo se llama Aniversario
        $aniversario->fill($data); // Llenar el modelo con los datos
        $aniversario->save(); // Guardar en la base de datos
    
        // Redirigir con mensaje de éxito
        return redirect()->route('app.aniversario.index')->with('success', 'Asistente registrado exitosamente.');
    }
    
    


}