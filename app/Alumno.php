<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class Alumno extends Authenticatable
{
    use SoftDeletes;

    protected $guard = 'alumnos';

    protected $fillable = [
        'nombres', 'apellidos', 'dni', 'tipo_documento', 'genero', 'nacionalidad', 'estado_civil', 'telefono', 'email', 'fecha_nacimiento', 'provincia_id', 'distrito_id',
        'area_id', 'ciclo', 'usuario_alumno', 'password', 'direccion', 'foto', 'hoja_de_vida', 'presentacion', 'aprobado',  'egresado',
        'anio_egreso', 'semestre', 'salario', 'disponibilidad'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    function provincias()
    {
        return $this->belongsTo('\BolsaTrabajo\Provincia', 'provincia_id');
    }

    function distritos()
    {
        return $this->belongsTo('\BolsaTrabajo\Distrito', 'distrito_id');
    }

    function areas()
    {
        return $this->belongsTo('\BolsaTrabajo\Area', 'area_id');
    }

    function educaciones()
    {
        return $this->hasMany('\BolsaTrabajo\Educacion', 'alumno_id');
    }

    function experiencias()
    {
        return $this->hasMany('\BolsaTrabajo\ExperienciaLaboral', 'alumno_id');
    }

    function referencias()
    {
        return $this->hasMany('\BolsaTrabajo\ReferenciaLaboral', 'alumno_id');
    }

    static function ValidatePerfilAlumno()
    {
        $errors = [];

        $alumno = Alumno::find(Auth::guard('alumnos')->user()->id);

        if($alumno){

            if($alumno->telefono == null || $alumno->telefono == "")
                array_push($errors, "Ingrese el télefono");

            if($alumno->email == null || $alumno->email == "")
                array_push($errors, "Ingrese el email");

            if($alumno->fecha_nacimiento == null || $alumno->fecha_nacimiento == "")
                array_push($errors, "Ingrese la fecha de nacimiento");

            if($alumno->area_id == null || $alumno->area_id == "")
                array_push($errors, "Seleccione un programa de estudio ");

            if(count($alumno->educaciones) <= 0)
                array_push($errors, "Ingrese al menos una educación");
        }

        return $errors;
    }

}
