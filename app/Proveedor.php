<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{

    protected $table = 'proveedor'; // nombre exacto de la tabla
    protected $primaryKey = 'id_proveedor';

    protected $fillable = [
        'ruc',
        'razon_social',
        'direccion',
        'telefono',
        'email',
        'estado',
    ];
}
