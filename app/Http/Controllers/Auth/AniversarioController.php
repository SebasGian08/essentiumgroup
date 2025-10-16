<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

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
        return view('auth.aniversario.index');
    }


    public function list_all(Request $request)
    {
        $query = Aniversario::with('celula')->orderby('id', 'desc');

        if ($request->date_from) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $events = $query->get(['id', 'nombre', 'tel', 'foto', 'celula_id','created_at']);

        // Mapear los eventos para incluir la URL completa de la foto y el nombre de la célula
        $events = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'nombre' => $event->nombre,
                'tel' => $event->tel,
                'foto' => $event->foto,
                'celula_id' => $event->celula_id,
                'celula_nombre' => $event->celula ? $event->celula->nombre : null, // Asumiendo que la relación se llama 'celula'
                'created_at' => $event->created_at,
            ];
        });

        return response()->json($events);
    }

    public function partialView($id)
    {
        $entity = Aniversario::find($id);
        
        // Si no se encuentra la entidad, podrías redirigir o devolver un error
        if (!$entity) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        return view('auth.aniversario._Mantenimiento', [
            'Entity' => $entity,
        ]);
    }

    

    


    
    


}