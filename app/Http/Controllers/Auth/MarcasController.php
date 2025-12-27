<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use BolsaTrabajo\ProductoMarca;
use Illuminate\Support\Facades\Validator;

class MarcasController extends Controller
{
    /**
     * Mostrar listado de marcas
     */
    public function index()
    {
        // Obtener todas las marcas que no estén eliminadas
        $marcas = ProductoMarca::whereNull('deleted_at')->get();

        return view('auth.marcas.index', compact('marcas'));
    }

    /**
     * Retornar marcas para DataTable (opcional si usas AJAX)
     */
    public function list()
    {
        $marcas = ProductoMarca::whereNull('deleted_at')->get();

        // Formatear datos para DataTable
        $data = $marcas->map(function($marca) {
            return [
                'id_producto_marca' => $marca->id_producto_marca,
                'descripcion'       => $marca->descripcion,
                'estado'            => $marca->estado
            ];
        });

        return response()->json(['data' => $data]);
    }
}
    