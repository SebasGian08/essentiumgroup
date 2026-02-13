<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ComprasController extends Controller
{
    public function index()
    {
        $proveedores = DB::table('proveedor')->where('estado',1)->get();
        $productos   = DB::table('productos')->where('estado',1)->get();
        $metodosPago = DB::table('metodo_pagos')->where('estado',1)->get();

        return view('auth.compras.create', compact(
            'proveedores',
            'productos',
            'metodosPago'
        ));
    }

    public function store(Request $request)
    {
        // 1. Validación de campos
        $request->validate([
            'id_proveedor' => 'required|exists:proveedor,id_proveedor',
            'tipo_documento' => 'required|string',
            'numero_documento' => 'required|string',
            'fecha_compra' => 'required|date',
            'total' => 'required|numeric|min:0',
            'detalle' => 'required|array|min:1',
            'detalle.*.id_producto' => 'required|exists:productos,id_producto',
            'detalle.*.cantidad' => 'required|numeric|min:1',
            'detalle.*.costo' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // REGISTRAR COMPRA
            $idCompra = DB::table('compra')->insertGetId([
                'id_proveedor'     => $request->id_proveedor,
                'tipo_documento'   => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
                'fecha_compra'     => $request->fecha_compra,
                'total'            => $request->total,
                'observacion'      => $request->observacion,
                'estado'           => 1,
                'created_at'       => now(),
            ]);

            // DETALLE + KARDEX
            foreach ($request->detalle as $item) {
                $producto = DB::table('productos')
                    ->where('id_producto', $item['id_producto'])
                    ->lockForUpdate()
                    ->first();

                if (!$producto) {
                    throw new \Exception("El producto ID {$item['id_producto']} no existe.");
                }

                $stockAnterior = $producto->stock;
                $stockNuevo = $stockAnterior + $item['cantidad'];

                // CALCULAR PRECIO PROMEDIO PONDERADO
                $precioAnterior = $producto->precio_compra ?? 0;
                $cantidadAnterior = $stockAnterior;

                $precioNuevo = round(
                    (($precioAnterior * $cantidadAnterior) + ($item['costo'] * $item['cantidad'])) 
                    / ($cantidadAnterior + $item['cantidad']), 2
                );

                // Insertar detalle de compra
                DB::table('compra_detalle')->insert([
                    'id_compra'      => $idCompra,
                    'id_producto'    => $item['id_producto'],
                    'cantidad'       => $item['cantidad'],
                    'costo_unitario' => round($item['costo'], 2),
                    'subtotal'       => round($item['cantidad'] * $item['costo'], 2),
                ]);

                // Insertar kardex (ENTRADA_COMPRA)
                DB::table('kardex')->insert([
                    'id_producto'        => $item['id_producto'],
                    'fecha_movimiento'   => now(),
                    'id_tipo_movimiento' => 1, // ENTRADA_COMPRA
                    'motivo'             => 'COMPRA',
                    'id_origen'          => $idCompra,
                    'cantidad'           => $item['cantidad'],
                    'stock_anterior'     => $stockAnterior,
                    'stock_nuevo'        => $stockNuevo,
                    'costo_unitario'     => round($item['costo'], 2),
                    'costo_total'        => round($item['cantidad'] * $item['costo'], 2),
                ]);

                // Actualizar stock y precio de compra en productos
                DB::table('productos')
                    ->where('id_producto', $item['id_producto'])
                    ->update([
                        'stock' => $stockNuevo,
                        'precio_compra' => $precioNuevo
                    ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Compra registrada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function list_all(Request $request)
    {
        return response()->json([
            'data' => DB::table('compra')
                ->join('proveedor','proveedor.id_proveedor','=','compra.id_proveedor')
                ->select(
                    'compra.id_compra',
                    'compra.fecha_compra',
                    'compra.tipo_documento',
                    'compra.numero_documento',
                    'proveedor.razon_social',
                    'compra.total',
                    'compra.estado'
                )
                ->orderBy('compra.fecha_compra','desc')
                ->get()
        ]);
    }

    public function verlistado()
    {
        $User = Auth::guard('web')->user();
        $userId = $User->id;

        return view('auth.compras.listado', compact('userId'));
    }


    public function delete(Request $request)
    {
        DB::table('compra')
            ->where('id_compra',$request->id)
            ->update(['estado'=>0]);
    }
}