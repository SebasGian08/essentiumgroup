<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Calendario extends Model
    {
        use SoftDeletes;

        protected $fillable = [
            'id','nombre','fecha_registro','tema','libro','estado','responsable'
        ];
    
        public $timestamps = false;
    
        protected $dates = ['deleted_at'];
    

        
    }