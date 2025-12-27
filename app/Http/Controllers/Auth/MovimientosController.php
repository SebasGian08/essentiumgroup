<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class MovimientosController extends Controller
{
    public function index()
    {
        $productos = DB::table('productos')->select('id_producto', 'descripcion')->get();
        $tipos = ['E' => 'Entrada', 'S' => 'Salida'];
        $motivos = ['COMPRA', 'DESPACHO PEDIDO'];

        return view('auth.movimientos.index', compact('productos', 'tipos', 'motivos'));
    }


    public function list_all(Request $request)
    {
        $query = DB::table('kardex')
            ->join('productos', 'kardex.id_producto', '=', 'productos.id_producto')
            ->select(
                'kardex.id_kardex',
                'productos.descripcion as producto',
                'kardex.fecha_movimiento',
                'kardex.tipo_movimiento',
                'kardex.motivo',
                'kardex.cantidad',
                'kardex.stock_anterior',
                'kardex.stock_nuevo',
                'kardex.costo_unitario',
                'kardex.costo_total'
            );

        if ($request->filled('fecha_inicio')) $query->where('fecha_movimiento', '>=', $request->fecha_inicio);
        if ($request->filled('fecha_fin')) $query->where('fecha_movimiento', '<=', $request->fecha_fin);
        if ($request->filled('producto_id')) {
            $query->where('kardex.id_producto', $request->producto_id);
        }
        if ($request->filled('tipo_movimiento')) $query->where('tipo_movimiento', $request->tipo_movimiento);
        if ($request->filled('motivo')) $query->where('motivo', $request->motivo);

        $movimientos = $query->orderBy('fecha_movimiento', 'desc')->get();

        return response()->json(['data' => $movimientos]);
    }

}