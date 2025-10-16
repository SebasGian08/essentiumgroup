<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'asistente_id', 'celula_id', 'fecha_inicio','accion','user_created'
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];


}
