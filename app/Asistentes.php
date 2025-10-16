<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Asistentes extends Model
    {
        use SoftDeletes;

        protected $fillable = [
            'id','nombre','descripcion','nombre','apellido','fecha_nac','distrito_id','direccion','tel','genero','celula_id','estado','foto', 'bautizado'
        ];
    
        public $timestamps = false;
    
        protected $dates = ['deleted_at'];
    
      // Definir la relación con Distrito
        public function distrito()
        {
            return $this->belongsTo(Distrito::class, 'distrito_id');
        }

        // Definir la relación con Celula
        public function celula()
        {
            return $this->belongsTo(Celula::class, 'celula_id');
        }
    
        
        
    }