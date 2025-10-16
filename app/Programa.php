<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Programa extends Model
{

    protected $table = 'programas';
    protected $primaryKey = 'id';
    public $timestamps = false; // Si no tienes timestamps en tu tabla programas
    /* SoftDeletes, esto sirve para dar un mantenimiento a la base de datos saber cuando sea editado o eliminado */
    use SoftDeletes;
        protected $fillable = [
            'registro',
            'tipo_programa',
            // Aquí puedes agregar otros campos que deseas permitir para asignación masiva
            'empresa',
            'puestouno',
            'puestouno',
            'puestodos',
            'puestotres',
            'puestocuatro',
            'responsable',

            'postulantes',
            'evaluando',
            'contratados',
            'descartado',

        ];
    public function participantes()
    {
        return $this->hasMany(Participantes::class, 'id_programa', 'id');
    }
      
    
}
