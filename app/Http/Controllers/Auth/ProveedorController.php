<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use BolsaTrabajo\Proveedor;

class ProveedorController extends Controller
{
    public function index()
    {
        return view('auth.proveedores.index');
    }

    public function list()
    {
        // Traemos todos los proveedores sin filtrar por deleted_at
        $proveedores = Proveedor::all()->map(function($prov) {
            return [
                'id_proveedor' => $prov->id_proveedor,
                'ruc' => $prov->ruc,
                'razon_social' => $prov->razon_social,
                'direccion' => $prov->direccion,
                'telefono' => $prov->telefono,
                'email' => $prov->email,
                'estado' => $prov->estado
            ];
        });

        return response()->json(['data' => $proveedores]);
    }

    public function delete(Request $request)
    {
        $proveedor = Proveedor::find($request->id);
        if ($proveedor) {
            $proveedor->delete(); // Esto borrará el registro permanentemente
            return response()->json(['success' => true, 'message' => 'Proveedor eliminado correctamente']);
        }
        return response()->json(['success' => false, 'message' => 'Proveedor no encontrado']);
    }
}
