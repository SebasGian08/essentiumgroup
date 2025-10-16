<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campamento extends Model
{
    use SoftDeletes;
    protected $table = 'campamento';
    protected $fillable = ['id','nombre', 'ministerio_id','tel', 'edad','foto','created_at'];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

     // Definir la relaci��n con Celula
    /*  public function celula()
     {
         return $this->belongsTo(Celula::class, 'celula_id');
     } */
}
