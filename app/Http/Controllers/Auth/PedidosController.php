<?php

namespace BolsaTrabajo\Http\Controllers\Auth;


use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Illuminate\Http\Request;
use BolsaTrabajo\User;
use BolsaTrabajo\MetodoPago;
use BolsaTrabajo\Ubigeo;
use BolsaTrabajo\Producto;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PedidosController extends Controller
{
    public function index()
    {
        // Usuario autenticado
        $User = Auth::guard('web')->user();
        $userId = $User->id;

        // Traer todos los usuarios activos (opcional, si necesitas listarlos)
        $users = User::where('estado', 1)
                    ->whereNull('deleted_at')
                    ->get();

        // Traer métodos de pago activos
        $metodosPago = MetodoPago::where('estado', 1)
                                ->whereNull('deleted_at')
                                ->get();

        // Traer ubigeo (departamentos, provincias o distritos)
        $ubigeos = Ubigeo::where('estado', 1)
                        ->whereNull('deleted_at')
                        ->get();

        // Traer productos activos
        $productos = Producto::where('estado', 1)
                            ->whereNull('deleted_at')
                            ->get();

        return view('auth.pedidos.index', compact('userId', 'users', 'metodosPago', 'ubigeos', 'productos'));
    }

    public function verlistado(){
        $User = Auth::guard('web')->user();
        $userId = $User->id;
        return view('auth.pedidos.listado' , compact('userId'));
    }

    public function gestiondepedidos(){
        $motorizados = User::where('profile_id', 7)
                   ->where('estado', 1)
                   ->whereNull('deleted_at')
                   ->get();
        return view('auth.pedidos.gestion', compact('motorizados'));
    }

    public function store(Request $request)
    {
        // ===============================
        // DEBUG INICIAL
        // ===============================
        //dd($request->productos);

        // ===============================
        // VALIDACIONES DEL FORMULARIO
        // ===============================
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|exists:users,id',
            'razon_social' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'fecha_pedido' => 'required|date',
            'fecha_entrega' => 'required|date',
            'metodo_pago' => 'required|exists:metodo_pagos,id_metodo_pago',
            'direccion_envio' => 'required|string|max:255',
            'ubigeo_envio' => 'required|exists:ubigeos,id_ubigeo',

            // ===============================
            // VALIDACIÓN DE PRODUCTOS
            // ===============================
                'productos' => 'required|array|min:1',
                'productos.*.id_producto' => [
                    'required',
                    Rule::exists('productos', 'id_producto')
                        ->whereNull('deleted_at')
                ],

                'productos.*.cantidad' => 'required|integer|min:1',
                'productos.*.precio' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // ===============================
        // VALIDACIÓN DE STOCK (NEGOCIO)
        // ===============================
        foreach ($request->productos as $p) {
            $producto = DB::table('productos')
                ->where('id_producto', $p['id_producto'])
                ->first();

            if (!$producto) {
                return redirect()->back()
                    ->withErrors(['productos' => 'Producto no encontrado.'])
                    ->withInput();
            }

            if ($p['cantidad'] > $producto->stock) {
                return redirect()->back()
                    ->withErrors([
                        'productos' => "Stock insuficiente para el producto: {$producto->descripcion}"
                    ])
                    ->withInput();
            }
        }

        // ===============================
        // TRANSACCIÓN
        // ===============================
        DB::beginTransaction();

        try {
            // ===============================
            // CÁLCULOS
            // ===============================
            $codigoPedido = 'PED-' . time();

            $subtotal = 0;
            foreach ($request->productos as $p) {
                $subtotal += $p['cantidad'] * $p['precio'];
            }

            $igv = $subtotal * 0.18;
            $total = $subtotal + $igv;

            // ===============================
            // REGISTRAR PEDIDO
            // ===============================
            $pedidoId = DB::table('pedidos')->insertGetId([
                'codigo_pedido' => $codigoPedido,
                'id_usuario' => $request->id_usuario,
                'nombre_cliente' => $request->razon_social,
                'direccion_cliente' => $request->direccion,
                'telefono_cliente' => $request->telefono,
                'fecha_pedido' => $request->fecha_pedido,
                'fecha_entrega' => $request->fecha_entrega,
                'id_metodo_pago' => $request->metodo_pago,
                'tipo_pedido' => $request->punto_llegada ?? 'cliente',
                'direccion_envio' => $request->direccion_envio,
                'ubigeo_envio' => $request->ubigeo_envio,
                'subtotal' => $subtotal,
                'igv' => $igv,
                'total' => $total,
                'observacion' => $request->referencia,
                'estado' => 1,
                'estado_pedido' => 'PENDIENTE',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ===============================
            // DETALLE DEL PEDIDO
            // ===============================
            foreach ($request->productos as $p) {
                DB::table('pedidos_detalle')->insert([
                    'id_pedido' => $pedidoId,
                    'id_producto' => $p['id_producto'],
                    'cantidad' => $p['cantidad'],
                    'precio_unitario' => $p['precio'],
                    'total' => $p['cantidad'] * $p['precio'],
                ]);

                // Descontar stock
                DB::table('productos')
                    ->where('id_producto', $p['id_producto'])
                    ->decrement('stock', $p['cantidad']);
            }

            // ===============================
            // SEGUIMIENTO INICIAL
            // ===============================
            DB::table('pedido_seguimiento')->insert([
                'id_pedido' => $pedidoId,
                'id_estado_seguimiento' => 1,
                'id_motorizado' => null,
                'id_usuario_registro' => auth()->id(),
                'comentario' => 'Pedido creado automáticamente.',
                'evidencia_chat' => 0,
                'evidencia_llamada_chat' => 0,
                'evidencia_entrega' => 0,
                'evidencia_soporte' => 0,
                'created_at' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('auth.pedidos')
                ->with('success', 'Pedido registrado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Ocurrió un error al registrar el pedido: ' . $e->getMessage());
        }
    }


    public function list_all(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;

        $query = DB::table('pedidos')
            ->leftJoin('ubigeos', 'ubigeos.id_ubigeo', '=', 'pedidos.ubigeo_envio')

            // SEGUIMIENTO NORMALIZADO
            ->leftJoin(DB::raw('(
                SELECT 
                    ps.id_pedido,
                    GROUP_CONCAT(es.nombre) AS estados,
                    MAX(ps.comentario) AS comentario
                FROM pedido_seguimiento ps
                JOIN estado_seguimiento es 
                    ON es.id_estado_seguimiento = ps.id_estado_seguimiento
                WHERE ps.deleted_at IS NULL
                GROUP BY ps.id_pedido
            ) AS ps'), 'ps.id_pedido', '=', 'pedidos.id_pedido')

            // PRODUCTOS
            ->leftJoin(DB::raw('(
                SELECT 
                    pd.id_pedido,
                    GROUP_CONCAT(CONCAT(p.descripcion, " (", pd.cantidad, ")")) AS productos
                FROM pedidos_detalle pd
                JOIN productos p ON pd.id_producto = p.id_producto
                GROUP BY pd.id_pedido
            ) AS pdp'), 'pdp.id_pedido', '=', 'pedidos.id_pedido')

            ->select(
                'pedidos.id_pedido',
                'pedidos.nombre_cliente',
                'pedidos.id_usuario',
                'pedidos.fecha_entrega',
                'pedidos.fecha_pedido',
                'pedidos.direccion_cliente',
                'pedidos.telefono_cliente',
                'pedidos.direccion_envio',
                'pedidos.estado_pedido',
                'pedidos.created_at',
                'pedidos.total',
                'pedidos.observacion',

                'ubigeos.departamento',
                'ubigeos.provincia',
                'ubigeos.distrito',

                'ps.comentario',
                'ps.estados',
                'pdp.productos'
            )
            ->where('pedidos.id_usuario', $userId)
            ->orderBy('pedidos.created_at', 'desc');

        // FILTROS DE FECHA
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('pedidos.fecha_pedido', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('pedidos.fecha_pedido', '<=', $request->fecha_fin);
        }

        $pedidos = $query->get()->map(function ($pedido) {

            // PRODUCTOS A ARRAY
            $pedido->productos = collect(explode(',', $pedido->productos ?? ''))
                ->map(function ($p) {
                    preg_match('/^(.*)\s\((\d+)\)$/', trim($p), $m);
                    return [
                        'descripcion' => $m[1] ?? trim($p),
                        'cantidad' => $m[2] ?? 0
                    ];
                });

            // ESTADOS A ARRAY
            $pedido->estado_seguimiento = $pedido->estados
                ? explode(',', $pedido->estados)
                : [];

            unset($pedido->estados);

            return $pedido;
        });

        return response()->json(['data' => $pedidos]);
    }


    public function gestionList(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;

        $pedidos = DB::table('pedidos as p')
            ->leftJoin('users as u', 'u.id', '=', 'p.id_usuario')
            ->leftJoin('ubigeos as ub', 'ub.id_ubigeo', '=', 'p.ubigeo_envio')
            ->leftJoin(DB::raw('(SELECT pd.id_pedido, GROUP_CONCAT(CONCAT(prod.descripcion, " (", pd.cantidad, ")")) as productos
                                FROM pedidos_detalle pd
                                JOIN productos prod ON pd.id_producto = prod.id_producto
                                GROUP BY pd.id_pedido) as pdp'), 'pdp.id_pedido', '=', 'p.id_pedido')
            ->where('p.id_usuario', $userId)
            ->where('p.estado_pedido', 'PENDIENTE') // <-- FILTRO SOLO PENDIENTES
            ->select(
                'p.id_pedido',
                'p.codigo_pedido',
                'p.fecha_pedido',
                'p.total',
                'u.nombres as nombre_usuario',
                'ub.departamento',
                'ub.provincia',
                'ub.distrito',
                'pdp.productos'
            )
            ->orderByDesc('p.created_at')
            ->get();

        return response()->json(['data' => $pedidos]);
    }




 public function gestionGet(Request $request)
    {
        $pedido = DB::table('pedidos as p')
            ->leftJoin('users as u', 'u.id', '=', 'p.id_usuario')
            ->leftJoin('ubigeos as ub', 'ub.id_ubigeo', '=', 'p.ubigeo_envio')
            ->where('p.id_pedido', $request->id_pedido)
            ->select(
                'p.id_pedido',
                'p.codigo_pedido',
                'p.nombre_cliente as cliente',
                'p.total',
                'p.fecha_pedido',
                'u.nombres as nombre_usuario',
                'u.email as email_usuario',
                'u.telefono as telefono_usuario',
                'ub.departamento',
                'ub.provincia',
                'ub.distrito'
            )
            ->first();

        // Último seguimiento (solo info necesaria)
        $seguimiento = DB::table('pedido_seguimiento')
            ->where('id_pedido', $request->id_pedido)
            ->orderByDesc('id_seguimiento')
            ->first(['id_seguimiento','id_estado_seguimiento','id_motorizado','comentario']);

        // Detalles de productos (agregando código y opcionalmente imagen)
        $detalles = DB::table('pedidos_detalle as pd')
            ->join('productos as prod', 'prod.id_producto', '=', 'pd.id_producto')
            ->where('pd.id_pedido', $request->id_pedido)
            ->select(
                'prod.id_producto',
                'prod.codigo_producto',
                'prod.descripcion',
                'prod.imagen', // si quieres mostrar imagen en el detalle
                'pd.cantidad',
                'pd.precio_unitario' // si quieres subtotal
            )
            ->get();

        return response()->json([
            'data' => [
                'id_pedido' => $pedido->id_pedido,
                'codigo_pedido' => $pedido->codigo_pedido,
                'cliente' => $pedido->cliente,
                'departamento' => $pedido->departamento,
                'provincia' => $pedido->provincia,
                'distrito' => $pedido->distrito,
                'total' => $pedido->total,
                'fecha_pedido' => $pedido->fecha_pedido,
                'seguimiento' => $seguimiento,
                'detalles' => $detalles
            ]
        ]);
    }



   public function gestionUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $userId = Auth::guard('web')->user()->id;

            // 1. Registrar seguimiento del pedido
            $idSeguimiento = DB::table('pedido_seguimiento')->insertGetId([
                'id_pedido' => $request->id_pedido,
                'id_estado_seguimiento' => $request->id_estado_seguimiento,
                'id_motorizado' => $request->id_motorizado,
                'id_usuario_registro' => $userId,
                'comentario' => $request->comentario,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 2. Kardex de SALIDA y actualización de stock
            $detalles = DB::table('pedidos_detalle')
                ->where('id_pedido', $request->id_pedido)
                ->get();

            foreach ($detalles as $item) {
                // stock actual con lock
                $producto = DB::table('productos')
                    ->where('id_producto', $item->id_producto)
                    ->lockForUpdate()
                    ->first();

                $stockAnterior = $producto->stock;
                $stockNuevo = $stockAnterior - $item->cantidad; // SALIDA

                if ($stockNuevo < 0) {
                    throw new \Exception("Stock insuficiente para el producto: {$item->descripcion}");
                }

                // kardex (SALIDA)
                DB::table('kardex')->insert([
                    'id_producto' => $item->id_producto,
                    'fecha_movimiento' => now(),
                    'tipo_movimiento' => 'S', // S de Salida
                    'motivo' => 'DESPACHO PEDIDO',
                    'id_origen' => $request->id_pedido,
                    'cantidad' => $item->cantidad,
                    'stock_anterior' => $stockAnterior,
                    'stock_nuevo' => $stockNuevo,
                    'costo_unitario' => $item->precio_unitario ?? 0,
                    'costo_total' => ($item->precio_unitario ?? 0) * $item->cantidad
                ]);

                // actualizar stock del producto
                DB::table('productos')
                    ->where('id_producto', $item->id_producto)
                    ->update(['stock' => $stockNuevo]);
            }

            // 3. Actualizar estado del pedido a 'VALIDADO' o 'DESPACHADO'
            DB::table('pedidos')
                ->where('id_pedido', $request->id_pedido)
                ->update(['estado_pedido' => 'VALIDADO', 'updated_at' => now()]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pedido validado y despachado correctamente. Kardex actualizado.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al despachar el pedido.',
                'error' => $e->getMessage()
            ], 500);
        }
    }








}