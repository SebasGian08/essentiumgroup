<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aviso extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'empresa_id', 'titulo', 'link', 'area_id', 'modalidad_id', 'horario_id', 'distrito_id', 'descripcion', 'direccion', 'referencia_direccion', 'salario','vacantes','solicita_carrera','solicita_grado_a','ciclo_cursa','periodo_vigencia'
    ];

    protected $dates = ['deleted_at'];

    function empresas()
    {
        return $this->belongsTo('\BolsaTrabajo\Empresa', 'empresa_id');
    }

    function areas()
    {
       /*  return $this->belongsTo('\BolsaTrabajo\Area', 'area_id'); */
        return $this->belongsTo('\BolsaTrabajo\Area','solicita_carrera');
    }

    function modalidades()
    {
        return $this->belongsTo('\BolsaTrabajo\Modalidad', 'modalidad_id');
    }

    function horarios()
    {
        return $this->belongsTo('\BolsaTrabajo\Horario', 'horario_id');
    }

    function provincias()
    {
        return $this->belongsTo('\BolsaTrabajo\Provincia', 'provincia_id');
    }

    function distritos()
    {
        return $this->belongsTo('\BolsaTrabajo\Distrito', 'distrito_id');
    }

}
