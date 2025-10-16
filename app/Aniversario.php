<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aniversario extends Model
{
    use SoftDeletes;

    protected $fillable = ['id','nombre', 'celula_id','tel', 'foto','created_at'];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

     // Definir la relaci¨®n con Celula
     public function celula()
     {
         return $this->belongsTo(Celula::class, 'celula_id');
     }
}
