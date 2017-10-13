<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Charts;

use App\Http\Controllers\UtilidadesController;
use App\Solicitud;
use App\Empresa;

class GraficosController extends Controller
{
    //
    public function getIndexGraficosInt(Request $request)
    {
        return view('sistema.amgraficos.gtiempo',compact('request'));
    }

    public static function getDatosGrafPie(Request $request)
    {

        $result = array();
        $des = array();
        $ttlo ='';
        $cnd = '';
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
                $cnd = 'porcentaje';
                break;

            case 'smot':
                $reporte = DB::select( DB::raw("select 'MONTO BS' as titulo, sum(solicitudes.fin_montobs) as data from solicitudes union select 'MONTO USD', sum(solicitudes.fin_montousd) from solicitudes order by titulo asc"));
                $ttlo = 'SOLICITUD/REQUERIMIENTO';
                $titulo = 'FINANCIAMIENTO';
                break;

            case 'sper':
                $permi = DB::select( DB::raw("SELECT count(permisologia.institucion) as data from permisologia"));
                $reporte = DB::select( DB::raw("SELECT permisologia.institucion as titulo, count(permisologia.institucion) as data from permisologia GROUP BY permisologia.institucion"));
                $ttlo = 'SOLICITUD/REQUERIMIENTO';
                $titulo = 'PERMISOLOGIA Y OTROS (Ttal '.$permi[0]->data.')';
                break;
            case 'sac1':
                $solicitudes = DB::select( DB::raw("select count(acciones.remitido_a) as data from acciones where acciones.ra_nivel = 1"));
                //dd($solicitudes);
                $reporte = DB::select( DB::raw("select acciones.remitido_a as titulo, count(acciones.remitido_a) as data from acciones where acciones.ra_nivel = 1 group by acciones.remitido_a"));
                $ttlo = 'SOLICITUDES/ACCIONES';
                $titulo = 'POR ENTE, DIRECCIÓN U OTRO (Ttal '.$solicitudes[0]->data.')';
                break;
            case 'sac2':
                $reporte = DB::select( DB::raw("select acciones.remitido_a as titulo, count(acciones.remitido_a) as data from acciones where acciones.ra_nivel = 2 group by acciones.remitido_a"));
                $ttlo = 'SOLICITUDES/ACCIONES';
                $titulo = '2º NIVEL REMITIDO A';
                break;
            case 'esec':
                $total = DB::select( DB::raw("SELECT count(empresas.sector) as cant from empresas"));
                $reporte = DB::select( DB::raw("SELECT empresas.sector as titulo , count(empresas.sector) as data from empresas GROUP BY empresas.sector having empresas.sector is not null ORDER BY sector asc "));
                $ttlo = 'EMPRESAS/SECTORES';
                $titulo = 'Ttal. '.$total[0]->cant;
                break;
            case 'banp':
                $total = DB::select( DB::raw("SELECT count(empresas.sector) as cant from empresas"));
                $reporte = DB::select( DB::raw("SELECT 'BANCO DE VENEZUELA' as titulo, (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO DE VENEZUELA%') as data union all SELECT 'BANCO DEL TESORO', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO DEL TESORO%') union all  SELECT 'BANCO BICENTENARIO',(select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO BICENTENARIO%') union all  SELECT 'BANCOEX', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCOEX%') union all  SELECT 'BANDES', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANDES%') union all  SELECT 'BANCO AGRICOLA', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO AGRICOLA%') union all  SELECT 'BANFANB', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANFANB%') union all  SELECT 'BANCO DE LA MUJER', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO DE LA MUJER%') union all  SELECT 'FONDO GUBERNAMENTAL', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%FONDO GUBERNAMENTAL%') ORDER BY data desc"));
                $ttlo = 'SOLICITUD DE FINANCIAMIENTO';
                $titulo = 'BANCO DE PREFERENCIA';
                break;
        }


        foreach($reporte as $rep ){
            $cat = ($rep->titulo == 'PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS') ? 'PERMISOLOGIA' : $rep->titulo;
            $data = (empty($rep->data))? 0 : $rep->data;
            $des[] = "{ 'name' : '".$cat."', 'y' : ".$data.", 'color' : '".UtilidadesController::rnd_color('d')."', 'pulled' : true }";

        }

        array_push($result,
            ['des' => $des],
            ['titulo' => $titulo],
            ['ttlo' => $ttlo ],
            ['cnd' => $cnd ]
        );

        return view('sistema.amgraficos.grafico_pie', compact('result'));
    }

    public static function getDatosGrafBar(Request $request)
    {
        switch ($request->cnd) {
            case 'div':
                $reporte = DB::select(DB::raw("SELECT 'ATENDIDAS' as dem, count(DISTINCT empresas.empresa) as cant FROM empresas INNER JOIN solicitudes  ON solicitudes.emp_rif = empresas.rif UNION SELECT 'ACCIONES EJECUTADAS', count(empresas.empresa) FROM empresas  INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif INNER JOIN acciones ON acciones.id_sol = solicitudes.id order by cant desc"));
                $titulo = 'RELACION DE EMPRESAS';
                $ttlo = 'ATENDIDAS  VS  ACCIONES EJECUTADAS';
                $tipo = '';
                // $cat[] = 'EMPRESAS Acciones';
                break;
            case 'div1':
                $reporte = DB::select(DB::raw("select 'REGISTRADAS' as dem, count(*) as cant from empresas UNION SELECT 'ATENDIDAS' , count(DISTINCT empresas.empresa) FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif order by cant desc"));

                $titulo = 'RELACION DE EMPRESAS';
                $ttlo = 'REGISTRADAS Y  ATENDIDAS';
                $tipo = '';
                //$cat[] = 'EMPRESAS Solicitudes';
                break;
            case 'div2':
                $reporte = DB::select(DB::raw("SELECT 'ATENDIDAS' as dem, count(DISTINCT empresas.empresa) as cant FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif UNION SELECT 'SOLICITUDES', count(empresas.empresa) FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif  order by cant desc"));

                $titulo = 'RELACION DE EMPRESAS';
                $ttlo = 'ATENDIDAS Y SOLICITUDES';
                $tipo = '';
                //$cat[] = 'EMPRESAS Solicitudes';
                break;

            case 'osol':
                $total = DB::table('solicitudes')->count();
                $reporte = DB::select( DB::raw("select solicitudes.objeto as dem, count(solicitudes.objeto) as cant from solicitudes group by solicitudes.objeto  order by cant desc"));
                $titulo = 'SOLICITUD/REQUERIMIENTO ';
                $ttlo = '(Ttal '.$total.')';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'smot':
                $reporte = DB::select( DB::raw("select 'MONTO BS' as dem, sum(solicitudes.fin_montobs) as cant from solicitudes union select 'MONTO USD', sum(solicitudes.fin_montousd) from solicitudes order by cant desc"));
                $titulo = 'SOLICITUD DE FINANCIAMIENTO';
                $ttlo = 'BS VS USD';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '';
                break;
            case 'edos':
                $emp = DB::table('empresas')->count();
                $reporte = DB::select( DB::raw("SELECT estados.nombre as dem, count(empresas.edo) as cant FROM empresas INNER JOIN estados ON empresas.edo = estados.id GROUP BY estados.nombre ORDER BY cant desc"));
                $titulo = 'DISTRIBUCION GEOGRAFICA';
                $ttlo = 'EMPRESAS REGISTRADAS (Ttal '.$emp.')';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'fbs':
                $reporte = DB::select( DB::raw("SELECT empresas.empresa as dem, solicitudes.fin_montobs as cant FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif where solicitudes.objeto = 'FINANCIAMIENTO' and solicitudes.fin_montobs <> 0 order by fin_montobs desc"));
                $titulo = 'SOLICITUD DE FINANCIAMIENTO';
                $ttlo ='(BS)';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'fusd':
                $reporte = DB::select( DB::raw("SELECT empresas.empresa as dem, solicitudes.fin_montousd as cant FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif where solicitudes.objeto = 'FINANCIAMIENTO' and solicitudes.fin_montousd <> 0 order by fin_montousd desc"));
                $titulo = 'SOLICITUD DE FINANCIAMIENTO';
                $ttlo = '(USD)';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'eseg':
                $seg = DB::select( DB::raw("select count(status) as cant from seguimiento where seguimiento.id = (select max(s.id) from seguimiento as s where s.id_sol = seguimiento.id_sol) "));
                $reporte = DB::select( DB::raw("select status as dem, count(status) as cant from seguimiento where seguimiento.id = (select max(s.id) from seguimiento as s where s.id_sol = seguimiento.id_sol) GROUP BY status order by cant desc"));
                $titulo = 'ESTATUS DE SEGUIMIENTO';
                $ttlo =  '(Ttal '.$seg[0]->cant.')';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'eval':
                $reporte = DB::select( DB::raw("select (select uu.nombre from users as uu where uu.id = u.id) as dem, round(( select avg(suma) from ( select (case when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) IS NULL then 0  when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN PROCESO' then 25 when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and   seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN REVISION' then 50  when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'APROBADO' then 75 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 ELSE 100 end) as suma from empresas,solicitudes  where  empresas.rif = solicitudes.emp_rif and  solicitudes.fecha BETWEEN  '2017-05-01' AND now() and empresas.usuario = u.id GROUP BY empresas.empresa, solicitudes.objeto, solicitudes.id, solicitudes.fecha )as suma  ),2) as cant from users as u where u.rol = 2 GROUP BY u.id HAVING ( select avg(suma) from (select (case when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) IS NULL then 0 when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN PROCESO' then 25 when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN REVISION' then 50 when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'APROBADO' then 75 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 ELSE 100 end) as suma from empresas,solicitudes  where empresas.rif = solicitudes.emp_rif and solicitudes.fecha BETWEEN '2017-05-01' AND now() and empresas.usuario = u.id GROUP BY empresas.empresa, solicitudes.objeto, solicitudes.id, solicitudes.fecha )as suma ) IS NOT NULL  order by cant desc"));
                $titulo = 'EVALUACION RESPONSABLES/SATISFACCIÓN EMPRESARIAL';
                $ttlo =  '(%)';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'banp':
                $reporte = DB::select( DB::raw("SELECT 'BANCO DE VENEZUELA' as dem, (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO DE VENEZUELA%') as cant union all SELECT 'BANCO DEL TESORO', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO DEL TESORO%') union all  SELECT 'BANCO BICENTENARIO',(select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO BICENTENARIO%') union all  SELECT 'BANCOEX', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCOEX%') union all  SELECT 'BANDES', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANDES%') union all  SELECT 'BANCO AGRICOLA', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO AGRICOLA%') union all  SELECT 'BANFANB', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANFANB%') union all  SELECT 'BANCO DE LA MUJER', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO DE LA MUJER%') union all  SELECT 'FONDO GUBERNAMENTAL', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%FONDO GUBERNAMENTAL%') ORDER BY cant desc"));

                $titulo = 'SOLICITUD DE FINANCIAMIENTO';
                $ttlo =  'BANCO DE PREFERENCIA';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;

        }

        $result = array();



        foreach($reporte as $rep ){
            $dem = ($rep->dem == 'PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS') ? 'PERMISOLOGIA' : $rep->dem;
            // $des[] = "{ name : '".$dem."', data : [".$rep->cant."] }";
            if($request->cnd == 'eval'){
                if($rep->cant <= 25){
                    $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#f44336" }';
                }
                elseif($rep->cant > 25 && $rep->cant <= 50){
                    $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#ff9800" }';
                }
                elseif($rep->cant > 50 && $rep->cant <= 75){
                    $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#2196f3" }';
                }else{
                    $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#4caf50" }';
                }

            }
            elseif($request->cnd == 'eseg'){
                switch ($rep->dem){
                    case 'EN PROCESO':
                        $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#90caf9" }';
                        break;
                    case 'EN REVISION':
                        $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#2196f3" }';
                        break;

                    case 'APROBADO':
                        $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#d4fad6" }';
                        break;
                    case 'CULMINADO':
                        $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#4caf50" }';
                        break;
                    case 'RECHAZADO':
                        $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#f44336" }';
                        break;
                    case 'LIQUIDADO':
                        $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#c77bd4" }';
                        break;

                    case 'ENTREGADO':
                        $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#9c27b0" }';
                        break;

                }

            }
            else{
                $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "'.UtilidadesController::rnd_color('l').'" }';
            }

            //"{name: '".$dem."',    y: ".$rep->cant."}";
            $cat[] = $dem;

        }
        //color:'".UtilidadesController::rnd_color()."',
        array_push($result,
            ['des' => $des],
            ['cat' => $cat],
            ['titulo' => $titulo],
            ['type' => $tipo],
            ['ttlo' => $ttlo]
        );

        return view('sistema.amgraficos.grafico_bar', compact('result'));

    }

    public static function getDatosGrafPieMp(Request $request)
    {
        $result = array();
        $cnd ='';

        switch ($request->cnd){
            case 'tmpr':
                $total = DB::table('mprima')->count();
                $reporte = DB::select( DB::raw("select mprima.tipo dem, count(tipo) cant from mprima group by tipo order by dem asc"));
                $ttlo = 'SOLICITUD/REQUERIMIENTO';
                $titulo = 'MATERIA PRIMA (Ttal '.$total.')';
                break;
        }

        foreach($reporte as $rep ){
            //$cat = ($rep->titulo == 'PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS') ? 'PERMISOLOGIA' : $rep->titulo;
            //$data = (empty($rep->data))? 0 : $rep->data;
            $des[] = "{ 'name' : '".substr($rep->dem,0,3)."', 'y' : ".$rep->cant.", 'color' : '".UtilidadesController::rnd_color('d')."', 'pulled' : true }";

        }

        array_push($result,
            ['des' => $des],
            ['titulo' => $titulo],
            ['ttlo' => $ttlo ],
            ['cnd' => $cnd ],
            ['nac' => GraficosController::getDetalleMPrima() ],
            ['impo' => GraficosController::getDetalleMPrima('IMPORTADA') ]
        );

        return view('sistema.amgraficos.grafico_pie_mp', compact('result'));
    }

    public static function getDetalleMPrima($tipo = 'NACIONAL')
    {
        $reporte = DB::select( DB::raw("select mprima.descripcion dem, count(descripcion) cant from mprima where tipo = '".$tipo."' group by descripcion order by dem asc"));
        foreach($reporte as $rep ){
            //$cat = ($rep->titulo == 'PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS') ? 'PERMISOLOGIA' : $rep->titulo;
            //$data = (empty($rep->data))? 0 : $rep->data;
            $des[] = "{ 'name' : '".$rep->dem."', 'y' : ".$rep->cant.", 'color' : '".UtilidadesController::rnd_color('t')."' , 'pulled' : true  }";

        }
        return $des;

    }

    /****************************intervalo de fecha************************************/
    public static function getDatosGrafPieInt(Request $request)
    {

        $result = array();
        $des = array();
        $ttlo ='';
        $cnd = '';
        switch ($request->cnd){
            case 'osol':
                $total = DB::table('solicitudes')->whereBetween('solicitudes.fecha', array($request->f1, $request->f2) )->count();
                $reporte = DB::select( DB::raw("select solicitudes.objeto as titulo, count(solicitudes.objeto) as data from solicitudes  where solicitudes.fecha between '".$request->f1."' and '".$request->f2."'  group by solicitudes.objeto"));
                $ttlo = 'SOLICITUD/REQUERIMIENTO';
                $titulo = 'OBJ DE LA SOLICITUD - Ttal '.$total;
                $cnd = 'porcentaje';
                break;

            case 'smot':
                $reporte = DB::select( DB::raw("select 'MONTO BS' as titulo, sum(solicitudes.fin_montobs) as data from solicitudes where solicitudes.fecha between '".$request->f1."' and '".$request->f2."' union select 'MONTO USD', sum(solicitudes.fin_montousd) from solicitudes where solicitudes.fecha between '".$request->f1."' and '".$request->f2."' order by titulo asc"));
                $ttlo = 'SOLICITUD/REQUERIMIENTO';
                $titulo = 'FINANCIAMIENTO';
                break;

            case 'sper':
                $permi = DB::select( DB::raw("SELECT count(permisologia.institucion) as data from permisologia,solicitudes where permisologia.sol_id = solicitudes.id and solicitudes.fecha between '".$request->f1."' and '".$request->f2."' "));
                $reporte = DB::select( DB::raw("SELECT permisologia.institucion as titulo, count(permisologia.institucion) as data from permisologia,solicitudes where permisologia.sol_id = solicitudes.id and solicitudes.fecha between '".$request->f1."' and '".$request->f2."' GROUP BY permisologia.institucion"));
                $ttlo = 'SOLICITUD/REQUERIMIENTO';
                $titulo = 'PERMISOLOGIA Y OTROS (Ttal '.$permi[0]->data.')';
                break;
            case 'sac1':
                $solicitudes = DB::select( DB::raw("select count(acciones.remitido_a) as data from acciones where acciones.fecha between '".$request->f1."' and '".$request->f2."' and acciones.ra_nivel = 1"));
                //dd($solicitudes);
                $reporte = DB::select( DB::raw("select acciones.remitido_a as titulo, count(acciones.remitido_a) as data from acciones where acciones.fecha between '".$request->f1."' and '".$request->f2."' and  acciones.ra_nivel = 1 group by acciones.remitido_a"));
                $ttlo = 'SOLICITUDES/ACCIONES';
                $titulo = 'POR ENTE, DIRECCIÓN U OTRO (Ttal '.$solicitudes[0]->data.')';
                break;
            case 'sac2':
                $reporte = DB::select( DB::raw("select acciones.remitido_a as titulo, count(acciones.remitido_a) as data from acciones where acciones.fecha between '".$request->f1."' and '".$request->f2."' and  acciones.ra_nivel = 2 group by acciones.remitido_a"));
                $ttlo = 'SOLICITUDES/ACCIONES';
                $titulo = '2º NIVEL REMITIDO A';
                break;
            case 'esec':
                $total = DB::select( DB::raw("SELECT count(empresas.sector) as cant from empresas where created_at::date between '".$request->f1."' and '".$request->f2."'"));
                $reporte = DB::select( DB::raw("SELECT empresas.sector as titulo , count(empresas.sector) as data from empresas  where created_at::date between '".$request->f1."' and '".$request->f2."' GROUP BY empresas.sector having empresas.sector is not null ORDER BY sector asc "));
                $ttlo = 'EMPRESAS/SECTORES';
                $titulo = 'Ttal. '.$total[0]->cant;
                break;
            case 'banp':
                $total = DB::select( DB::raw("SELECT count(empresas.sector) as cant from empresas"));
                $reporte = DB::select( DB::raw("SELECT 'BANCO DE VENEZUELA' as titulo, (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO DE VENEZUELA%' and fecha between '".$request->f1."' and '".$request->f2."') as data union all SELECT 'BANCO DEL TESORO', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO DEL TESORO%'  and fecha between '".$request->f1."' and '".$request->f2."') union all  SELECT 'BANCO BICENTENARIO',(select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO BICENTENARIO%'  and fecha between '".$request->f1."' and '".$request->f2."') union all  SELECT 'BANCOEX', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCOEX%'  and fecha between '".$request->f1."' and '".$request->f2."') union all  SELECT 'BANDES', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANDES%'  and fecha between '".$request->f1."' and '".$request->f2."') union all  SELECT 'BANCO AGRICOLA', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO AGRICOLA%'  and fecha between '".$request->f1."' and '".$request->f2."') union all  SELECT 'BANFANB', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANFANB%'  and fecha between '".$request->f1."' and '".$request->f2."') union all  SELECT 'BANCO DE LA MUJER', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO DE LA MUJER%'  and fecha between '".$request->f1."' and '".$request->f2."') union all  SELECT 'FONDO GUBERNAMENTAL', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%FONDO GUBERNAMENTAL%'  and fecha between '".$request->f1."' and '".$request->f2."') ORDER BY data desc"));
                $ttlo = 'SOLICITUD DE FINANCIAMIENTO';
                $titulo = 'BANCO DE PREFERENCIA';
                break;
        }


        foreach($reporte as $rep ){
            $cat = ($rep->titulo == 'PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS') ? 'PERMISOLOGIA' : $rep->titulo;
            $data = (empty($rep->data))? 0 : $rep->data;
            $des[] = "{ 'name' : '".$cat."', 'y' : ".$data.", 'color' : '".UtilidadesController::rnd_color('d')."', 'pulled' : true }";

        }

        array_push($result,
            ['des' => $des],
            ['titulo' => $titulo],
            ['ttlo' => $ttlo ],
            ['cnd' => $cnd ]
        );

        return view('sistema.amgraficos.grafico_pie', compact('result'));
    }

    public static function getDatosGrafBarInt(Request $request)
    {
        $des = array();
        $cat = array();
        $titulo='';
        $tipo='';
        $ttlo='';
        switch ($request->cnd) {
            case 'div':
                $reporte = DB::select(DB::raw("SELECT 'ATENDIDAS' as dem, count(DISTINCT empresas.empresa) as cant FROM empresas INNER JOIN solicitudes  ON solicitudes.emp_rif = empresas.rif where solicitudes.fecha between '".$request->f1."' and '".$request->f2."' UNION SELECT 'ACCIONES EJECUTADAS', count(empresas.empresa) FROM empresas  INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif INNER JOIN acciones ON acciones.id_sol = solicitudes.id where acciones.fecha between '".$request->f1."' and '".$request->f2."' order by cant desc"));
                $titulo = 'RELACION DE EMPRESAS';
                $ttlo = 'ATENDIDAS  VS  ACCIONES EJECUTADAS';
                $tipo = '';
                // $cat[] = 'EMPRESAS Acciones';
                break;
            case 'div1':
                $reporte = DB::select(DB::raw("select 'REGISTRADAS' as dem, count(*) as cant from empresas where created_at::date between '".$request->f1."' and '".$request->f2."' UNION SELECT 'ATENDIDAS' , count(DISTINCT empresas.empresa) FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif where solicitudes.fecha between '".$request->f1."' and '".$request->f2."' order by cant desc"));

                $titulo = 'RELACION DE EMPRESAS';
                $ttlo = 'REGISTRADAS Y  ATENDIDAS';
                $tipo = '';
                //$cat[] = 'EMPRESAS Solicitudes';
                break;
            case 'div2':
                $reporte = DB::select(DB::raw("SELECT 'ATENDIDAS' as dem, count(DISTINCT empresas.empresa) as cant FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif where solicitudes.fecha between '".$request->f1."' and '".$request->f2."' UNION SELECT 'SOLICITUDES', count(empresas.empresa) FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif where solicitudes.fecha between '".$request->f1."' and '".$request->f2."'  order by cant desc"));

                $titulo = 'RELACION DE EMPRESAS';
                $ttlo = 'ATENDIDAS Y SOLICITUDES';
                $tipo = '';
                //$cat[] = 'EMPRESAS Solicitudes';
                break;
            case 'osol':
                $total = DB::table('solicitudes')->whereBetween('created_at', array($request->f1, $request->f2) )->count();
                $reporte = DB::select( DB::raw("select solicitudes.objeto as dem, count(solicitudes.objeto) as cant from solicitudes where solicitudes.fecha between '".$request->f1."' and '".$request->f2."' group by solicitudes.objeto  order by cant desc"));
                $titulo = 'SOLICITUD/REQUERIMIENTO ';
                $ttlo = '(Ttal '.$total.')';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'smot':
                $reporte = DB::select( DB::raw("select 'MONTO BS' as dem, sum(solicitudes.fin_montobs) as cant from solicitudes where solicitudes.fecha between '".$request->f1."' and '".$request->f2."' union select 'MONTO USD', sum(solicitudes.fin_montousd) from solicitudes where solicitudes.fecha between '".$request->f1."' and '".$request->f2."' order by cant desc"));
                $titulo = 'SOLICITUD DE FINANCIAMIENTO';
                $ttlo = 'BS VS USD';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '';
                break;
            case 'edos':
                $emp = DB::table('empresas')->count();
                $reporte = DB::select( DB::raw("SELECT estados.nombre as dem, count(empresas.edo) as cant FROM empresas INNER JOIN estados ON empresas.edo = estados.id where empresas.created_at::date between '".$request->f1."' and '".$request->f2."' GROUP BY estados.nombre ORDER BY cant desc"));
                $titulo = 'DISTRIBUCION GEOGRAFICA';
                $ttlo = 'EMPRESAS REGISTRADAS (Ttal '.$emp.')';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'fbs':
                $reporte = DB::select( DB::raw("SELECT empresas.empresa as dem, solicitudes.fin_montobs as cant FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif where solicitudes.objeto = 'FINANCIAMIENTO' and solicitudes.fin_montobs <> 0 and solicitudes.fecha between  '".$request->f1."' and '".$request->f2."' order by fin_montobs desc"));
                $titulo = 'SOLICITUD DE FINANCIAMIENTO';
                $ttlo ='(BS)';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'fusd':
                $reporte = DB::select( DB::raw("SELECT empresas.empresa as dem, solicitudes.fin_montousd as cant FROM empresas INNER JOIN solicitudes ON solicitudes.emp_rif = empresas.rif where solicitudes.objeto = 'FINANCIAMIENTO' and solicitudes.fin_montousd <> 0 and solicitudes.fecha between '".$request->f1."' and '".$request->f2."' order by fin_montousd desc"));
                $titulo = 'SOLICITUD DE FINANCIAMIENTO';
                $ttlo = '(USD)';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'eseg':
                $seg = DB::select( DB::raw("select count(status) as cant from seguimiento where seguimiento.id = (select max(s.id) from seguimiento as s where s.id_sol = seguimiento.id_sol) and seguimiento.fecha between '".$request->f1."' and '".$request->f2."'"));
                $reporte = DB::select( DB::raw("select status as dem, count(status) as cant from seguimiento where seguimiento.id = (select max(s.id) from seguimiento as s where s.id_sol = seguimiento.id_sol) and seguimiento.fecha between '".$request->f1."' and '".$request->f2."' GROUP BY status order by cant desc"));
                $titulo = 'ESTATUS DE SEGUIMIENTO';
                $ttlo =  '(Ttal '.$seg[0]->cant.')';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'eval':
                $reporte = DB::select( DB::raw("select (select uu.nombre from users as uu where uu.id = u.id) as dem, round(( select avg(suma) from ( select (case when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) IS NULL then 0  when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN PROCESO' then 25 when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and   seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN REVISION' then 50  when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'APROBADO' then 75 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 ELSE 100 end) as suma from empresas,solicitudes  where  empresas.rif = solicitudes.emp_rif and  solicitudes.fecha BETWEEN  '".$request->f1."' and '".$request->f2."' and empresas.usuario = u.id GROUP BY empresas.empresa, solicitudes.objeto, solicitudes.id, solicitudes.fecha )as suma  ), 2) as cant from users as u where u.rol = 2 GROUP BY u.id HAVING ( select avg(suma) from (select (case when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) IS NULL then 0 when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN PROCESO' then 25 when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN REVISION' then 50 when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'APROBADO' then 75 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 ELSE 100 end) as suma from empresas,solicitudes  where empresas.rif = solicitudes.emp_rif and solicitudes.fecha BETWEEN '".$request->f1."' and '".$request->f2."' and empresas.usuario = u.id GROUP BY empresas.empresa, solicitudes.objeto, solicitudes.id, solicitudes.fecha )as suma ) IS NOT NULL  order by cant desc"));
                $titulo = 'EVALUACION RESPONSABLES/SATISFACCIÓN EMPRESARIAL';
                $ttlo =  '(%)';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;
            case 'banp':
                $reporte = DB::select( DB::raw("SELECT 'BANCO DE VENEZUELA' as dem, (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO DE VENEZUELA%' and solicitudes.fecha BETWEEN '".$request->f1."' and '".$request->f2."') as cant union all SELECT 'BANCO DEL TESORO', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO DEL TESORO%' and solicitudes.fecha BETWEEN '".$request->f1."' and '".$request->f2."') union all  SELECT 'BANCO BICENTENARIO',(select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO BICENTENARIO%' and solicitudes.fecha BETWEEN '".$request->f1."' and '".$request->f2."') union all  SELECT 'BANCOEX', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCOEX%' and solicitudes.fecha BETWEEN '".$request->f1."' and '".$request->f2."') union all  SELECT 'BANDES', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANDES%' and solicitudes.fecha BETWEEN '".$request->f1."' and '".$request->f2."') union all  SELECT 'BANCO AGRICOLA', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO AGRICOLA%' and solicitudes.fecha BETWEEN '".$request->f1."' and '".$request->f2."') union all  SELECT 'BANFANB', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANFANB%' and solicitudes.fecha BETWEEN '".$request->f1."' and '".$request->f2."') union all  SELECT 'BANCO DE LA MUJER', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%BANCO DE LA MUJER%' and solicitudes.fecha BETWEEN '".$request->f1."' and '".$request->f2."') union all  SELECT 'FONDO GUBERNAMENTAL', (select count(solicitudes.fin_banco) from solicitudes where solicitudes. fin_banco ilike '%FONDO GUBERNAMENTAL%' and solicitudes.fecha BETWEEN '".$request->f1."' and '".$request->f2."') ORDER BY cant desc"));

                $titulo = 'SOLICITUD DE FINANCIAMIENTO';
                $ttlo =  'BANCO DE PREFERENCIA';
                //$cat[] = 'OBJETO DE LA SOLICITUD';
                $tipo = '"rotate": true,';
                break;

        }

        $result = array();



        foreach($reporte as $rep ){
            $dem = ($rep->dem == 'PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS') ? 'PERMISOLOGIA' : $rep->dem;
            // $des[] = "{ name : '".$dem."', data : [".$rep->cant."] }";
            if($request->cnd == 'eval'){
                if($rep->cant <= 25){
                    $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#f44336" }';
                }
                elseif($rep->cant > 25 && $rep->cant <= 50){
                    $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#ff9800" }';
                }
                elseif($rep->cant > 50 && $rep->cant <= 75){
                    $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#2196f3" }';
                }else{
                    $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#4caf50" }';
                }

            }
            elseif($request->cnd == 'eseg'){
                switch ($rep->dem){
                    case 'EN PROCESO':
                        $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#90caf9" }';
                        break;
                    case 'EN REVISION':
                        $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#2196f3" }';
                        break;

                    case 'APROBADO':
                        $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#d4fad6" }';
                        break;
                    case 'CULMINADO':
                        $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#4caf50" }';
                        break;
                    case 'RECHAZADO':
                        $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#f44336" }';
                        break;
                    case 'LIQUIDADO':
                        $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#c77bd4" }';
                        break;

                    case 'ENTREGADO':
                        $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "#9c27b0" }';
                        break;

                }

            }
            else{
                $des[] = '{ "tipo": "'.$dem.'", "cantidad": '.$rep->cant.', "color": "'.UtilidadesController::rnd_color('l').'" }';
            }

            //"{name: '".$dem."',    y: ".$rep->cant."}";
            $cat[] = $dem;

        }
        //color:'".UtilidadesController::rnd_color()."',
        array_push($result,
            ['des' => $des],
            ['cat' => $cat],
            ['titulo' => $titulo],
            ['type' => $tipo],
            ['ttlo' => $ttlo]
        );

        return view('sistema.amgraficos.grafico_bar', compact('result'));

    }

    public static function getDatosGrafPieMpInt(Request $request)
    {
        $result = array();
        $des = array();
        $cnd ='';

        switch ($request->cnd){
            case 'tmpr':
                $total = DB::table('mprima')->join('solicitudes', 'mprima.id_sol', '=', 'solicitudes.id')->whereBetween('solicitudes.fecha', array($request->f1, $request->f2) )->count();
                $reporte = DB::select( DB::raw("select mprima.tipo dem, count(mprima.tipo) cant from mprima, solicitudes where solicitudes.id = mprima.id_sol and solicitudes.fecha BETWEEN '".$request->f1."' and '".$request->f2."' group by tipo order by dem asc"));
                $ttlo = 'SOLICITUD/REQUERIMIENTO';
                $titulo = 'MATERIA PRIMA (Ttal '.$total.')';
                break;
        }



            foreach($reporte as $rep ){
                //$cat = ($rep->titulo == 'PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS') ? 'PERMISOLOGIA' : $rep->titulo;
                //$data = (empty($rep->data))? 0 : $rep->data;
                $des[] = "{ 'name' : '".substr($rep->dem,0,3)."', 'y' : ".$rep->cant.", 'color' : '".UtilidadesController::rnd_color('d')."', 'pulled' : true }";

            }



        array_push($result,
            ['des' => $des],
            ['titulo' => $titulo],
            ['ttlo' => $ttlo ],
            ['cnd' => $cnd ],
            ['nac' => GraficosController::getDetalleMPrimaInt($request) ],
            ['impo' => GraficosController::getDetalleMPrimaInt($request,'IMPORTADA') ]
        );
       // dd($result);

        return view('sistema.amgraficos.grafico_pie_mp', compact('result'));
    }

    public static function getDetalleMPrimaInt($request,$tipo = 'NACIONAL')
    {
        $des = array();
        $reporte = DB::select( DB::raw("select mprima.descripcion dem, count(mprima.descripcion) cant from mprima, solicitudes where mprima.tipo = '".$tipo."'  and solicitudes.id = mprima.id_sol and solicitudes.fecha BETWEEN '".$request->f1."' and '".$request->f2."' group by descripcion order by dem asc"));

        foreach($reporte as $rep ){
            //$cat = ($rep->titulo == 'PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS') ? 'PERMISOLOGIA' : $rep->titulo;
            //$data = (empty($rep->data))? 0 : $rep->data;
            $des[] = "{ 'name' : '".$rep->dem."', 'y' : ".$rep->cant.", 'color' : '".UtilidadesController::rnd_color('t')."' , 'pulled' : true  }";

        }
        return $des;

    }


}

/*

select (select uu.nombre from users as uu where uu.user = u.user) as dem,  round( ( select avg(suma) from ( select (case when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) IS NULL then 0  when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN PROCESO' then 25 when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN REVISION' then 50 when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'APROBADO' then 75 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 ELSE 100 end) as suma from logs,solicitudes  where  logs.empresa = solicitudes.emp_rif and  logs.modulo = 'SOLICITUD' and logs.accion ilike '%AGREGAR%' and solicitudes.fecha BETWEEN  '2017-05-01' AND now() and logs.usuario = u.user GROUP BY logs.empresa, solicitudes.objeto, solicitudes.id, solicitudes.fecha )as suma  ), 2) as cant from users as u where u.rol = 2 GROUP BY u.user HAVING ( select avg(suma) from (select (case when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) IS NULL then 0 when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN PROCESO' then 25 when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN REVISION' then 50 when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'APROBADO' then 75 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 ELSE 100 end) as suma from logs,solicitudes  where logs.empresa = solicitudes.emp_rif and logs.modulo = 'SOLICITUD' and logs.accion ilike '%AGREGAR%' and solicitudes.fecha BETWEEN '2017-05-01' AND now() and logs.usuario = u.user GROUP BY logs.empresa, solicitudes.objeto, solicitudes.id, solicitudes.fecha )as suma ) IS NOT NULL order by cant desc

select (select uu.nombre from users as uu where uu.user = u.user) as dem,  round( ( select avg(suma) from ( select (case when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) IS NULL then 0  when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN PROCESO' then 25 when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN REVISION' then 50 when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'APROBADO' then 75 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 ELSE 100 end) as suma from logs,solicitudes  where  logs.empresa = solicitudes.emp_rif and  logs.modulo = 'SOLICITUD' and logs.accion ilike '%AGREGAR%' and solicitudes.fecha BETWEEN  '".$request->f1."' and '".$request->f2."' and logs.usuario = u.user GROUP BY logs.empresa, solicitudes.objeto, solicitudes.id, solicitudes.fecha )as suma  ), 2) as cant from users as u where u.rol = 2 GROUP BY u.user HAVING ( select avg(suma) from (select (case when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) IS NULL then 0 when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN PROCESO' then 25 when ( select seguimiento.status from seguimiento  where seguimiento.id_sol = solicitudes.id  and  seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'EN REVISION' then 50 when ( select seguimiento.status from seguimiento where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'APROBADO' then 75 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 when ( select seguimiento.status  from seguimiento  where seguimiento.id_sol = solicitudes.id  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = solicitudes.id )) = 'CULMINADO' then 100 ELSE 100 end) as suma from logs,solicitudes  where logs.empresa = solicitudes.emp_rif and logs.modulo = 'SOLICITUD' and logs.accion ilike '%AGREGAR%' and solicitudes.fecha BETWEEN '".$request->f1."' and '".$request->f2."' and logs.usuario = u.user GROUP BY logs.empresa, solicitudes.objeto, solicitudes.id, solicitudes.fecha )as suma ) IS NOT NULL order by cant desc
 *
 *
 *
 */