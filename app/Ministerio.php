<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Ministerio extends Model
{

    protected $table = 'ministerios';
    protected $primaryKey = 'id';
    public $timestamps = false; // Si no tienes timestamps en tu tabla programas
    /* SoftDeletes, esto sirve para dar un mantenimiento a la base de datos saber cuando sea editado o eliminado */
    use SoftDeletes;
        protected $fillable = [
            'nombre',

        ];

    
}