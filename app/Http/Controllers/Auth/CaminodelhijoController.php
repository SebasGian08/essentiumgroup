<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;

class CaminodelhijoController extends Controller
{
    public function index()
    {
        return view('auth.caminodelhijo.index');
    }

    public function getUsers()
    {
        $urlServidorSecundario = "http://elcaminodelhijo.pe/api/ListaUsuarios.php"; // Cambia esta URL según sea necesario
        $solicitud = curl_init();

        curl_setopt_array($solicitud, [
            CURLOPT_URL => $urlServidorSecundario,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
            ],
        ]);

        $response = curl_exec($solicitud);
        $err = curl_error($solicitud);
        curl_close($solicitud);

        if ($err) {
            return response()->json(['error' => "cURL Error #: " . $err], 500);
        } else {
            return response()->json(json_decode($response, true));
        }
    }
}
