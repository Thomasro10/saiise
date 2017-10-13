<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReporteExcelController extends Controller
{
    //
    public function getEmpresasTipo(Request $request)
    {

        Excel::create('reporte_'.$request->titulo, function($excel) use ($request) {
            $excel->sheet('New sheet', function($sheet)  use ($request) {

                $reporte = DB::table('encuestas')
                    ->join('estados', 'encuestas.edo', '=', 'estados.id')
                    ->join('municipios', 'encuestas.mcpio', '=', 'municipios.id')
                    ->join('parroquias', 'encuestas.pquia', '=', 'parroquias.id')
                    ->select('encuestas.id',
                        DB::raw("to_char(fecha, 'DD/MM/YYYY') as fecha"),
                        'encuestas.nanfi','encuestas.cianf','encuestas.naten','encuestas.ciaten','encuestas.cargoaten',
                        'encuestas.empresa','encuestas.rif','encuestas.telf','encuestas.email','encuestas.edo',
                        'encuestas.mcpio','encuestas.pquia','encuestas.direccion','encuestas.tempresa','encuestas.ntrabajadores',
                        'encuestas.acteconomica','encuestas.aeespec','encuestas.capinstalada','encuestas.medida',
                        'encuestas.pdc2013','encuestas.pdc2014','encuestas.pdc2015','encuestas.pdc2016','encuestas.pdcactual',
                        'encuestas.capoperativa','encuestas.motor','encuestas.motorespc','encuestas.mprima',
                        'encuestas.descripcion','encuestas.mercabast','encuestas.rubros','encuestas.obstaculos',
                        'estados.nombre AS estado','municipios.nombre AS municipio','parroquias.nombre AS parroquia')
                ;
                $sheet->loadView('sistema.excel.reporte', array('reporte' => $reporte) );
            });
        })->download('xls');
    }
}
