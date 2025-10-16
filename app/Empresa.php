<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Empresa extends Authenticatable
{
    use SoftDeletes;

    protected $guard = 'empresasw';

    protected $fillable = [
        'ruc', 'razon_social', 'nombre_comercial', 'name_comercio', 'actividad_economica_empresa', 'link', 'provincia_id', 'distrito_id', 'direccion', 'referencia', 'telefono', 'email',
        'usuario_empresa', 'password',  'pagina_web', 'descripcion', 'logo', 'nombre_contacto', 'apellido_contacto', 'cargo_contacto', 'telefono_contacto',
        'email_contacto', 'aprobado', 'tipo_persona', 'nombre_paciente', 'enfermedad_paciente', 'evidencias_paciente'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    function actividad_economicas()
    {
        return $this->belongsTo('\BolsaTrabajo\Actividad_economica', 'actividad_economica_empresa');
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
