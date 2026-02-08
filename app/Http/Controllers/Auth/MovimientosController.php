<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class MovimientosController extends Controller
{
    public function index()
    {
        // Productos activos
        $productos = DB::table('productos')
            ->select('id_producto', 'descripcion')
            ->where('estado', 1)
            ->get();

        // Tipos de movimiento desde tabla
        $tipos = DB::table('tipo_movimiento_kardex')
            ->select('id_tipo_movimiento', 'nombre', 'codigo')
            ->get();

        // Motivos principales
        $motivos = ['COMPRA', 'DESPACHO PEDIDO', 'ANULACION', 'DEVOLUCION', 'ENTREGA PEDIDO'];

        return view('auth.movimientos.index', compact('productos', 'tipos', 'motivos'));
    }

    public function list_all(Request $request)
    {
        $query = DB::table('kardex')
            ->join('productos', 'kardex.id_producto', '=', 'productos.id_producto')
            ->join('tipo_movimiento_kardex', 'kardex.id_tipo_movimiento', '=', 'tipo_movimiento_kardex.id_tipo_movimiento')
            ->select(
                'kardex.id_kardex',
                'productos.descripcion as producto',
                'kardex.fecha_movimiento',
                'tipo_movimiento_kardex.nombre as tipo_movimiento',
                'tipo_movimiento_kardex.codigo',
                'kardex.motivo',
                'kardex.cantidad',
                'kardex.stock_anterior',
                'kardex.stock_nuevo',
                'kardex.costo_unitario',
                'kardex.costo_total'
            );

        // Filtros
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('kardex.fecha_movimiento', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('kardex.fecha_movimiento', '<=', $request->fecha_fin);
        }
        if ($request->filled('producto_id')) {
            $query->where('kardex.id_producto', $request->producto_id);
        }
        if ($request->filled('id_tipo_movimiento')) {
            $query->where('kardex.id_tipo_movimiento', $request->id_tipo_movimiento);
        }
        if ($request->filled('motivo')) {
            $query->where('kardex.motivo', $request->motivo);
        }

        $movimientos = $query->orderBy('kardex.fecha_movimiento', 'desc')->get();

        return response()->json(['data' => $movimientos]);
    }
}
