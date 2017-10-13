<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    //
    protected $table = 'vis_visitas';
    protected $fillable = [
        'visitado_por','banco_acom',"fecha","operatividad","ciiu","tipo_emp","trabajadores","tnum","servicios","objeto","l_prod","nc_prod","nc_mprima","pclientes","pedo","pproductivo","observacion","emp_rif",
    ];
}
