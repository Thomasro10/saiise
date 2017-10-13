<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitasInvPer extends Model
{
    //
    protected $table = 'vis_invper';
    protected $fillable = [
        "financiamiento","montobs","montousd","uso","pdicom","sdicom","nsubastas","asignacion","rfinaciamiento","cartera","montofin","permisos","vis_id"
    ];
}
