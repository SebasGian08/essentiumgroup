<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Asistencia extends Model
    {
        use SoftDeletes;

        protected $fillable = [
            'id','programa_id','fecha_registro','celula_id','asistente_id','estado','motivo','id_user'
        ];
    
        public $timestamps = false;
    
        protected $dates = ['deleted_at'];
    
      // Definir la relación con Distrito
        public function programa()
        {
            return $this->belongsTo(TipoPrograma::class, 'programa_id');
        }

        // Definir la relación con Celula
        public function celula()
        {
            return $this->belongsTo(Celula::class, 'celula_id');
        }
        
        public function asistente()
        {
            return $this->belongsTo(Asistentes::class, 'asistente_id');
        }
         public function usuario()
        {
            return $this->belongsTo(User::class, 'id_user');
        }
        
        
    }