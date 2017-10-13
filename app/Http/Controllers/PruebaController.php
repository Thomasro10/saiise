<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Charts;

use App\Http\Controllers\UtilidadesController;
use App\Solicitud;

class PruebaController extends Controller
{
    //
    public function getIndex(){
        return 'sirve';
    }

    public static function getDatosGrafPie(Request $request)
    {

        $result = array();
        $des = array();
        $ttlo ='';
        switch ($request->cnd){
            case 'temp':
                $reporte = DB::select( DB::raw("select encuestas.tempresa as titulo, count(encuestas.tempresa) as data from encuestas GROUP BY encuestas.tempresa"));
                $titulo = 'TIPO';
                break;
            case 'ntra':
                $reporte = DB::select( DB::raw("select encuestas.ntrabajadores as titulo, count(encuestas.ntrabajadores) as data from encuestas GROUP BY encuestas.ntrabajadores"));
                $titulo = 'Nº DE TRABAJADORES';
                break;
            case 'mtor':
                $reporte = DB::select( DB::raw("select encuestas.motor as titulo, count(encuestas.motor) as data from encuestas GROUP BY encuestas.motor"));
                $titulo = 'MOTOR';
                break;
            case 'aeco':
                $reporte = DB::select( DB::raw("select encuestas.acteconomica as titulo, count(encuestas.acteconomica) as data from encuestas GROUP BY encuestas.acteconomica"));
                $titulo = 'ACTIVIDAD ECONÓMICA';
                break;
            case 'cope':
                $reporte = DB::select( DB::raw("select encuestas.capoperativa as titulo, count(encuestas.capoperativa) as data from encuestas GROUP BY encuestas.capoperativa"));
                $titulo = 'CAPACIDAD OPERATIVA';
                break;
            case 'mpri':
                $reporte = DB::select( DB::raw("select encuestas.mprima as titulo, count(encuestas.mprima) as data from encuestas GROUP BY encuestas.mprima"));
                $titulo = 'MATERIA PRIMA';
                break;
            case 'maba':
                $reporte = DB::select( DB::raw("select encuestas.mercabast as titulo, count(encuestas.mercabast) as data from encuestas GROUP BY encuestas.mercabast"));
                $titulo = 'MERCADO A ABASTECER';
                break;
            case 'rubr':
                $reporte = DB::select( DB::raw("select encuestas.rubros as titulo, count(encuestas.rubros) as data from encuestas GROUP BY encuestas.rubros"));
                $titulo = 'RUBROS';
                break;
            // financieros
            case 'div':
                $reporte = DB::select( DB::raw("select rqfinanciamiento.divpropias as titulo, count(rqfinanciamiento.divpropias) as data from rqfinanciamiento GROUP BY rqfinanciamiento.divpropias"));
                $titulo = 'DIVISAS PROPIAS';
                break;
            case 'exp':
                $reporte = DB::select( DB::raw("select rqfinanciamiento.exportar as titulo, count(rqfinanciamiento.exportar) as data from rqfinanciamiento GROUP BY rqfinanciamiento.exportar"));
                $titulo = 'CAPACIDAD PARA EXPORTAR';
                break;
            case 'rfi':
                $reporte = DB::select( DB::raw("select rqfinanciamiento.rfinancieros as titulo, count(rqfinanciamiento.rfinancieros) as data from rqfinanciamiento GROUP BY rqfinanciamiento.rfinancieros"));
                $titulo = 'RECURSOS FINANCIEROS';
                break;
            case 'osol':
                $total = DB::table('solicitudes')->count();
                $reporte = DB::select( DB::raw("select solicitudes.objeto as titulo, count(solicitudes.objeto) as data from solicitudes group by solicitudes.objeto"));
                $ttlo = 'SOLICITUD/REQUERIMIENTO';
                $titulo = 'OBJ DE LA SOLICITUD - Ttal '.$total;
                break;

            case 'smot':
                $reporte = DB::select( DB::raw("select 'MONTO BS' as titulo, sum(solicitudes.fin_montobs) as data from solicitudes union select 'MONTO USD', sum(solicitudes.fin_montousd) from solicitudes order by titulo asc"));
                $ttlo = 'SOLICITUD/REQUERIMIENTO';
                $titulo = 'FINANCIAMIENTO';
                break;

            case 'sper':
                $reporte = DB::select( DB::raw("SELECT permisologia.institucion as titulo, count(permisologia.institucion) as data from permisologia GROUP BY permisologia.institucion"));
                $ttlo = 'SOLICITUD/REQUERIMIENTO';
                $titulo = 'PERMISOLOGIA Y OTROS';
                break;
            case 'sac1':
                $reporte = DB::select( DB::raw("select acciones.remitido_a as titulo, count(acciones.remitido_a) as data from acciones where acciones.ra_nivel = 1 group by acciones.remitido_a"));
                $ttlo = 'SOLICITUDES/ACCIONES';
                $titulo = 'POR ENTE, DIRECCIÓN U OTRO';
                break;
            case 'sac2':
                $reporte = DB::select( DB::raw("select acciones.remitido_a as titulo, count(acciones.remitido_a) as data from acciones where acciones.ra_nivel = 2 group by acciones.remitido_a"));
                $ttlo = 'SOLICITUDES/ACCIONES';
                $titulo = '2º NIVEL REMITIDO A';
                break;
        }


        foreach($reporte as $rep ){
            $cat = ($rep->titulo == 'PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS') ? 'PERMISOLOGIA' : $rep->titulo;
            $data = (empty($rep->data))? 0 : $rep->data;
            $des[] = "{ 'name' : '".$cat."', 'y' : ".$data.", 'color' : '".UtilidadesController::rnd_color()."', 'pulled' : true }";

        }

        array_push($result,
            ['des' => $des],
            ['titulo' => $titulo],
            ['ttlo' => $ttlo ]
        );

        return view('sistema.amgraficos.grafico_pie', compact('result'));
    }

    public static function getDatosGrafBar(Request $request)
    {
        switch ($request->cnd) {
            case 'div':
                $reporte = DB::select(DB::raw("SELECT 'ATENDIDAS' as dem, count(DISTINCT empresas.empresa) as cant FROM empresas INNER JOIN solicitudes  ON solicitudes.emp_rif = empresas.rif UNION SELECT 'ACCIONES EJECUTADAS', count(DISTINCT empresas.empresa) FROM empresas  INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif INNER JOIN acciones ON acciones.id_sol = solicitudes.id order by cant desc"));
                $titulo = 'RELACION DE EMPRESAS  ATENDIDAS  VS  ACCIONES EJECUTADAS';
                $tipo = '';
                // $cat[] = 'EMPRESAS Acciones';
                break;
            case 'div1':
                $reporte = DB::select(DB::raw("select 'REGISTRADAS' as dem, count(*) as cant from empresas UNION SELECT 'ATENDIDAS' , count(DISTINCT empresas.empresa) FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif order by cant desc"));

                $titulo = 'RELACION DE EMPRESAS  REGISTRADAS Y  ATENDIDAS';
                $tipo = '';
                //$cat[] = 'EMPRESAS Solicitudes';
                break;
            case 'div2':
                $reporte = DB::select(DB::raw("SELECT 'ATENDIDAS' as dem, count(DISTINCT empresas.empresa) as cant FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif UNION SELECT 'SOLICITUDES', count(empresas.empresa) FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif  order by cant desc"));
                $titulo = 'RELACION DE EMPRESAS ATENDIDAS Y SOLICITUDES';
                $tipo = '';
                //$cat[] = 'EMPRESAS Solicitudes';
                break;

            case 'osol':
                $reporte = DB::select( DB::raw("select solicitudes.objeto as dem, count(solicitudes.objeto) as cant from solicitudes group by solicitudes.objeto  order by cant desc"));
                $titulo = 'SOLICITUD/REQUERIMIENTO';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'smot':
                $reporte = DB::select( DB::raw("select 'MONTO BS' as dem, sum(solicitudes.fin_montobs) as cant from solicitudes union select 'MONTO USD', sum(solicitudes.fin_montousd) from solicitudes order by cant desc"));
                $titulo = 'SOLICITUD DE FINANCIAMIENTO BS VS USD';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '';
                break;
            case 'edos':
                $reporte = DB::select( DB::raw("SELECT estados.nombre as dem, count(empresas.edo) as cant FROM empresas INNER JOIN estados ON empresas.edo = estados.id GROUP BY estados.nombre ORDER BY cant desc"));
                $titulo = 'UBICACION GEOGRAFICA DE EMPRESAS REGISTRADAS';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'fbs':
                $reporte = DB::select( DB::raw("SELECT empresas.empresa as dem, solicitudes.fin_montobs as cant FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif where solicitudes.objeto = 'FINANCIAMIENTO' and solicitudes.fin_montobs <> 0 order by fin_montobs desc"));
                $titulo = 'SOLICITUD DE FINANCIAMIENTO (BS)';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'fusd':
                $reporte = DB::select( DB::raw("SELECT empresas.empresa as dem, solicitudes.fin_montousd as cant FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif where solicitudes.objeto = 'FINANCIAMIENTO' and solicitudes.fin_montousd <> 0 order by fin_montousd desc"));
                $titulo = 'SOLICITUD DE FINANCIAMIENTO (USD)';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;

        }

        $result = array();



        foreach($reporte as $rep ){
            $dem = ($rep->dem == 'PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS') ? 'PERMISOLOGIA' : $rep->dem;
            // $des[] = "{ name : '".$dem."', data : [".$rep->cant."] }";
            $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "'.UtilidadesController::rnd_color().'" }';
            //"{name: '".$dem."',    y: ".$rep->cant."}";
            $cat[] = $dem;

        }
        //color:'".UtilidadesController::rnd_color()."',
        array_push($result,
            ['des' => $des],
            ['cat' => $cat],
            ['titulo' => $titulo],
            ['type' => $tipo]
        );

        return view('sistema.amgraficos.grafico_bar', compact('result'));

    }
}
