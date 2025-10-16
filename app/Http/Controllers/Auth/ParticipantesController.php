<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Participantes;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ParticipantesController extends Controller
{
    public function index()
    {
        return view('auth.programa.Participantes');
    }

        

}