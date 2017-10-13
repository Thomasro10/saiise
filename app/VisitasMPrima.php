<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitasMPrima extends Model
{
    //
    protected $table = 'vis_mprima';
    protected $fillable = [
        "producto","proveedor","cod_aran", "medida","creq","cdis", "vis_id"
    ];
}
