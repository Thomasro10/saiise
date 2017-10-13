<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitasProduccion extends Model
{
    //
    protected $table = 'vis_produccion';
    protected $fillable = [
        "producto","cod_aran","medida","cinstalada","coperativa","prodaant","prodact","prodmeta","vis_id"
    ];
}
