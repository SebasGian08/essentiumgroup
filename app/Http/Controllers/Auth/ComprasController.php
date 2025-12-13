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
        DB::beginTransaction();
        try {

            // 1. REGISTRAR COMPRA
            $idCompra = DB::table('compra')->insertGetId([
                'id_proveedor'      => $request->id_proveedor,
                'tipo_documento'    => $request->tipo_documento,
                'numero_documento'  => $request->numero_documento,
                'fecha_compra'      => $request->fecha_compra,
                'total'             => $request->total,
                'observacion'       => $request->observacion,
                'estado'            => 1,
                'created_at'        => now()
            ]);

            // 2. DETALLE + KARDEX
            foreach ($request->detalle as $item) {

                // detalle
                DB::table('compra_detalle')->insert([
                    'id_compra'     => $idCompra,
                    'id_producto'   => $item['id_producto'],
                    'cantidad'      => $item['cantidad'],
                    'costo_unitario'=> $item['costo'],
                    'subtotal'      => $item['subtotal']
                ]);

                // stock actual
                $producto = DB::table('productos')
                    ->where('id_producto', $item['id_producto'])
                    ->lockForUpdate()
                    ->first();

                $stockAnterior = $producto->stock;
                $stockNuevo    = $stockAnterior + $item['cantidad'];

                // kardex (ENTRADA)
                DB::table('kardex')->insert([
                    'id_producto'      => $item['id_producto'],
                    'fecha_movimiento' => now(),
                    'tipo_movimiento'  => 'E',
                    'motivo'           => 'COMPRA',
                    'id_origen'        => $idCompra,
                    'cantidad'         => $item['cantidad'],
                    'stock_anterior'   => $stockAnterior,
                    'stock_nuevo'      => $stockNuevo,
                    'costo_unitario'   => $item['costo'],
                    'costo_total'      => $item['cantidad'] * $item['costo']
                ]);

                // actualizar stock
                DB::table('productos')
                    ->where('id_producto', $item['id_producto'])
                    ->update(['stock' => $stockNuevo]);
            }

            DB::commit();
            return redirect()->back()->with('success','Compra registrada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
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