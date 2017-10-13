<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitasComercializacion extends Model
{
    //
    protected $table = 'vis_comercializacion';
    protected $fillable = [
        "producto","cod_aran","minterno","exportacion","preciobs","ventanac","ventanacest","exportacionusd","exportacionestusd","vis_id"
    ];
}
