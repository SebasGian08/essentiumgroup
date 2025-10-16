<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participantes extends Model
{
    

    protected $table = 'participantes';
    protected $primaryKey = 'id_participante';
    public $timestamps = false; // Si no tienes timestamps en tu tabla participantes

    use SoftDeletes;

    protected $fillable = [
        'id_participante',
        'dni',
        'nombres',
        'apellidos',
        'email',
        'tel',
        'estado',
        'tipo',
        'sede',
        'especialidad',
        'id_programa', // Asegúrate de tener el campo id_programa en fillable si es necesario
    ];

    // Definir la relación con el modelo Programa

    /* En Veremos  */
    public function programa()
    {
        return $this->belongsTo(Programa::class, 'id_programa', 'id');
    }

}

