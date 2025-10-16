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
        return view('auth.pedidos.gestion');
    }

    public function store(Request $request)
    {
        // Validación básica del pedido
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
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id_producto',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            // Generar código de pedido (puedes personalizarlo)
            $codigoPedido = 'PED-' . time();

            // Calcular subtotal, igv y total
            $subtotal = 0;
            foreach ($request->productos as $p) {
                $subtotal += $p['cantidad'] * $p['precio'];
            }
            $igv = $subtotal * 0.18;
            $total = $subtotal + $igv;

            // Crear pedido
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
                'estado_pedido' => 'pendiente',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insertar productos en pedidos_detalle
            foreach ($request->productos as $p) {
                DB::table('pedidos_detalle')->insert([
                    'id_pedido' => $pedidoId,
                    'id_producto' => $p['id'],
                    'cantidad' => $p['cantidad'],
                    'precio_unitario' => $p['precio'],
                    'total' => $p['cantidad'] * $p['precio'],
                ]);
            }

            DB::commit();
            return redirect()->route('auth.pedidos')->with('success', 'Pedido registrado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el pedido: ' . $e->getMessage());
        }
    }

    public function list_all(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;

        $query = DB::table('pedidos')
            ->leftJoin('ubigeos', 'ubigeos.id_ubigeo', '=', 'pedidos.ubigeo_envio')
            ->leftJoin(DB::raw('(SELECT id_pedido, comentario, pendiente, confirmado, validado, anulado, por_preparar, entregado 
                                FROM pedido_seguimiento) as ps'), 'ps.id_pedido', '=', 'pedidos.id_pedido')
            ->leftJoin(DB::raw('(SELECT pd.id_pedido, GROUP_CONCAT(CONCAT(p.descripcion, " (", pd.cantidad, ")")) as productos
                                FROM pedidos_detalle pd
                                JOIN productos p ON pd.id_producto = p.id_producto
                                GROUP BY pd.id_pedido) as pdp'), 'pdp.id_pedido', '=', 'pedidos.id_pedido')
            ->select(
                'pedidos.nombre_cliente',
                'pedidos.id_pedido',
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
                'ps.pendiente',
                'ps.confirmado',
                'ps.validado',
                'ps.anulado',
                'ps.por_preparar',
                'ps.entregado',
                'pdp.productos'
            )
            ->where('pedidos.id_usuario', $userId)
            ->orderBy('pedidos.created_at', 'desc');

        // Filtros de fechas
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('pedidos.fecha_pedido', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('pedidos.fecha_pedido', '<=', $request->fecha_fin);
        }

        $pedidos = $query->get()->map(function($pedido) {
            // Convertir productos concatenados en array de objetos
            $productos = explode(',', $pedido->productos ?? '');
            $productos = array_map(function($p) {
                preg_match('/^(.*)\s\((\d+)\)$/', trim($p), $matches);
                return [
                    'descripcion' => $matches[1] ?? trim($p),
                    'cantidad' => $matches[2] ?? ''
                ];
            }, $productos);

            $pedido->productos = $productos;

            // Generar array de estados de seguimiento
            $pedido->estado_seguimiento = [];
            foreach (['pendiente','confirmado','validado','anulado','por_preparar','entregado'] as $estado) {
                if ($pedido->$estado == 1) {
                    $pedido->estado_seguimiento[] = $estado;
                }
            }

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
        ->leftJoin('pedido_seguimiento as ps', 'ps.id_pedido', '=', 'p.id_pedido')
        ->leftJoin('metodo_pagos as m', 'm.id_metodo_pago', '=', 'p.id_metodo_pago') // relacionar con tu columna
        ->leftJoin(DB::raw('(SELECT pd.id_pedido, GROUP_CONCAT(CONCAT(prod.descripcion, " (", pd.cantidad, ")")) as productos
                            FROM pedidos_detalle pd
                            JOIN productos prod ON pd.id_producto = prod.id_producto
                            GROUP BY pd.id_pedido) as pdp'), 'pdp.id_pedido', '=', 'p.id_pedido')
        ->where('p.id_usuario', $userId)
        ->select(
            'p.id_pedido',
            'p.codigo_pedido',
            'p.tipo_pedido',
            'm.descripcion as metodo_pago', // <-- aquí tomas la descripción del método de pago
            'p.nombre_cliente as cliente',
            'p.telefono_cliente',
            'p.direccion_cliente',
            'p.observacion as referencia',
            'p.direccion_envio',
            'ps.motorizado',
            'p.fecha_pedido',
            'p.fecha_entrega',
            'p.total',
            'p.estado_pedido',
            'p.observacion',
            'p.created_at',
            'u.nombres as nombre_usuario',
            'u.email as email_usuario',
            'u.telefono as telefono_usuario',
            'ub.departamento',
            'ub.provincia',
            'ub.distrito',
            'ps.comentario',
            'ps.pendiente',
            'ps.confirmado',
            'ps.validado',
            'ps.anulado',
            'ps.por_preparar',
            'ps.entregado',
            'pdp.productos'
        )
        ->orderByDesc('p.created_at')
        ->get();


        return response()->json(['data' => $pedidos]);
    }

   // Obtener un pedido con detalle + seguimiento
    public function gestionGet(Request $request)
    {
        $id_pedido = $request->id_pedido;

        $pedido = DB::table('pedidos as p')
            ->leftJoin('ubigeos as u', 'p.ubigeo_envio', '=', 'u.id_ubigeo')
            ->leftJoin('users as us', 'p.id_usuario', '=', 'us.id')
            ->leftJoin('metodo_pagos as m', 'p.id_metodo_pago', '=', 'm.id_metodo_pago')
            ->where('p.id_pedido', $id_pedido)
            ->select(
                'p.id_pedido',
                'p.nombre_cliente',
                'p.direccion_cliente',
                'p.telefono_cliente',
                'p.fecha_pedido',
                'p.fecha_entrega',
                'm.descripcion as metodo_pago',
                'p.codigo_pedido',
                'p.tipo_pedido',
                'p.direccion_envio',
                'p.ubigeo_envio',
                'u.departamento',
                'u.provincia',
                'u.distrito',
                'p.subtotal',
                'p.igv',
                'p.total',
                'p.observacion',
                'us.nombres as nombre_usuario',
                'us.email as email_usuario',
                'us.telefono as telefono_usuario',
                'us.direccion as direccion_usuario',
                'us.ecommerce_nombre as ecommerce'
            )
            ->first();

        if (!$pedido) {
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado']);
        }

        $detalles = DB::table('pedidos_detalle as pd')
            ->join('productos as p', 'pd.id_producto', '=', 'p.id_producto')
            ->where('pd.id_pedido', $id_pedido)
            ->select(
                'pd.id_detalle',
                'pd.id_pedido',
                'pd.id_producto',
                'p.descripcion',
                'pd.cantidad',
                'pd.precio_unitario',
                'pd.total'
            )
            ->get();

        $seguimiento = DB::table('pedido_seguimiento')
            ->where('id_pedido', $id_pedido)
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'id_pedido' => $pedido->id_pedido,
                'nombre_cliente' => $pedido->nombre_cliente,
                'direccion_cliente' => $pedido->direccion_cliente,
                'telefono_cliente' => $pedido->telefono_cliente,
                'fecha_pedido' => $pedido->fecha_pedido,
                'fecha_entrega' => $pedido->fecha_entrega,
                'codigo_pedido' => $pedido->codigo_pedido,
                'metodo_pago' => $pedido->metodo_pago,
                'tipo_pedido' => $pedido->tipo_pedido,
                'direccion_envio' => $pedido->direccion_envio,
                'ubigeo_envio' => $pedido->ubigeo_envio,
                'departamento' => $pedido->departamento,
                'provincia' => $pedido->provincia,
                'distrito' => $pedido->distrito,
                'subtotal' => $pedido->subtotal,
                'igv' => $pedido->igv,
                'total' => $pedido->total,
                'observacion' => $pedido->observacion,
                'nombre_usuario' => $pedido->nombre_usuario,
                'email_usuario' => $pedido->email_usuario,
                'telefono_usuario' => $pedido->telefono_usuario,
                'direccion_usuario' => $pedido->direccion_usuario,
                'ecommerce' => $pedido->ecommerce,
                'detalles' => $detalles,
                'seguimiento' => $seguimiento
            ]
        ]);
    }


    public function gestionUpdate(Request $request)
    {
        $id_pedido = $request->id_pedido;

        // Estados enviados desde el form (pueden ser varios)
        $estadosMarcados = $request->estado ?? [];

        // Preparamos todos los estados posibles
        $estados = [
            'pendiente'     => in_array('pendiente', $estadosMarcados) ? 1 : 0,
            'confirmado'    => in_array('confirmado', $estadosMarcados) ? 1 : 0,
            'validado'      => in_array('validado', $estadosMarcados) ? 1 : 0,
            'por_preparar'  => in_array('por_preparar', $estadosMarcados) ? 1 : 0,
            'entregado'     => in_array('entregado', $estadosMarcados) ? 1 : 0,
            'anulado'       => in_array('anulado', $estadosMarcados) ? 1 : 0,
        ];

        // Guardamos el estado más reciente (para estado_entrega)
        $estadoEntrega = end($estadosMarcados) ?: null;

        // Buscar seguimiento actual
        $seguimiento = DB::table('pedido_seguimiento')->where('id_pedido', $id_pedido)->first();

        // Manejo de evidencias
        $paths = [];
        if ($request->hasFile('evidencias')) {
            foreach ($request->file('evidencias') as $file) {
                $path = $file->store("public/evidencias/{$id_pedido}");
                $paths[] = Storage::url($path);
            }
        }

        if ($seguimiento && !empty($seguimiento->evidencias_json)) {
            $anteriores = json_decode($seguimiento->evidencias_json, true);
            if (is_array($anteriores)) {
                $paths = array_merge($anteriores, $paths);
            }
        }

        $data = array_merge($estados, [
            'estado_entrega' => $estadoEntrega,
            'comentario'     => $request->comentario,
            'motorizado'     => $request->motorizado,
            'evidencias_json'=> json_encode($paths, JSON_UNESCAPED_SLASHES),
            'updated_at'     => now()
        ]);

        if ($seguimiento) {
            DB::table('pedido_seguimiento')
                ->where('id_pedido', $id_pedido)
                ->update($data);
        } else {
            $data['id_pedido'] = $id_pedido;
            $data['created_at'] = now();
            DB::table('pedido_seguimiento')->insert($data);
        }

        return response()->json([
            'success' => true,
            'message' => 'Seguimiento actualizado correctamente'
        ]);
    }






}