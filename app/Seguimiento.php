<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Seguimiento extends Model
{

    protected $table = 'seguimiento';
    protected $primaryKey = 'id';
    public $timestamps = false; // Si no tienes timestamps en tu tabla programas
    /* SoftDeletes, esto sirve para dar un mantenimiento a la base de datos saber cuando sea editado o eliminado */
    use SoftDeletes;
        protected $fillable = [
            'celula_id',
            'asistente_id',
            'fecha_contacto',
            'tipo_contacto',
            'detalle',
            'oracion',


        ];
    public function participantes()
    {
        return $this->hasMany(Participantes::class, 'id_programa', 'id');
    }
      
    
}
