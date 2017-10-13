<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class EvaluacionProyectoController extends Controller
{
    /*
     * responsables de evaluacion
     */

    public function getIndexResponsables()
    {
        return view('sistema.evaluacion.responsables');
    }

    public function getDataResponsables(Request $request)
    {
        //dd($request->all());
        $mprima = DB::table('eva_responsables')
            //->join('empresas', 'solicitudes.emp_rif', '=', 'empresas.rif')
            ->select('eva_responsables.id',
                'eva_responsables.cedula',
                'eva_responsables.nombre',
                'eva_responsables.perfil',
                'eva_responsables.modulo',
                'eva_responsables.status'

            );
        //dd($mprima);
        /*if(Auth::user()->rol == 30){
            $mprima->where('solicitudes.emp_rif', 'ilike', Auth::user()->empresa);
        }
        if(Auth::user()->rol == 2){
            $mprima->where('empresas.usuario', '=', Auth::user()->id);
        }

        if(Auth::user()->rol == 5){
            $mprima->where('solicitudes.objeto', '=', 'FINANCIAMIENTO');
        }*/
        /*if ($request->fecha_inicio &&  $request->fecha_fin) {
            $mprima->whereBetween('solicitudes.fecha', [$request->fecha_inicio, $request->fecha_fin]);
        }*/

        $datatable = Datatables::of($mprima)
            ->addColumn('accion', function ($mp) {
                $btn = '';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 40 || Auth::user()->rol == 41) {
                    $btn .= '<a href="javascript:void(0);" onclick="findUpdateEnc('.$mp->id.')"><i class="fa fa-edit fa-lg fa-border"></i></a> ';
                    if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 40){
                        $btn .= '<a href="javascript:void(0);" onclick="deleteEnc('.$mp->id.', '.$mp->cedula.')"><i class="fa fa-trash-o fa-lg fa-border style-danger"></i></a>';
                    }
                    if($mp->status == 0){
                        $btn .= ' <a href="javascript:void(0);"  title="Activar" onclick="actDesResp('.$mp->id.', '.$mp->status.', '.$mp->cedula.')"><i class="fa fa-check-square-o fa-lg fa-border"></i></a>';
                    }
                    else{
                        $btn .= ' <a href="javascript:void(0);"  title="desactivar" onclick="actDesResp('.$mp->id.', '.$mp->status.', '.$mp->cedula.')"><i class="fa fa-square-o fa-lg fa-border"></i></a>';
                    }
                }
                //<sup class="badge style-info">'.$mp->acciones.'</sup>

                return $btn;
            })
            ->editColumn('status', function ($mp) {
                if(!empty($mp->status == 1)){
                    return 'ACTIVO';
                }
                else{
                    return 'INACTIVO';
                }
            })
          /*  ->filterColumn('solicitudes.fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(solicitudes.fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })*/
            ->rawColumns(['accion']);

        return $datatable->make(true);

    }

    public function agregarResponsable(Request $request)
    {

        try{


            $addResp = DB::table('eva_responsables')->insert(
                array(
                    'cedula' => $request->cedula,
                    'nombre' => mb_strtoupper($request->nombre, 'UTF-8'),
                    'perfil' => mb_strtoupper($request->perfil, 'UTF-8'),
                    'modulo' => mb_strtoupper($request->modulo, 'UTF-8')
                )
            );

            /*
            $mprima->obstaculos =mb_strtoupper((empty($request->obstaculos))? '' : implode(',',$request->obstaculos));*/

            if($addResp){
                UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - RESPONSABLES', 'AGREGAR - '.$request->cedula);
                return response()->json(array(
                    'status' => 1,
                    'msg' => 'Registro agregado',
                ));
            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
    }

    public function buscarResponsable(Request $request)
    {
        if($request->ajax()) {
            $mprima = DB::table('eva_responsables')
                //->join('empresas', 'solicitudes.emp_rif', '=', 'empresas.rif')
                ->select('eva_responsables.id',
                    'eva_responsables.cedula',
                    'eva_responsables.nombre',
                    'eva_responsables.perfil',
                    'eva_responsables.modulo'
                )
                ->where('eva_responsables.id', '=', $request->id)->get();
            return response()->json($mprima);
        }
    }

    public function actualizarResponsable(Request $request)
    {
        try{
            $updResp = DB::table('eva_responsables')
                ->where('id', $request->id)
                ->update(
                    array(
                        'cedula' => $request->cedula,
                        'nombre' => mb_strtoupper($request->nombre, 'UTF-8'),
                        'perfil' => mb_strtoupper($request->perfil, 'UTF-8'),
                        'modulo' => mb_strtoupper($request->modulo, 'UTF-8')
                    )
                );

            if($updResp){
                UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - RESPONSABLES', 'ACTUALIZAR - '.$request->cedula);
                return response()->json(array(
                    'status' => 1,
                    'msg' => 'Registro actualizado',
                ));
            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => UtilidadesController::errorPostgres($e->getCode())
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }


    }

    public function eliminarResponsable(Request $request)
    {
        try{
            if($request->ajax()) {

                $legal = DB::table('eva_elegal')->where('eva_elegal.responsable', '=', $request->cedula)->count();
                $economico = DB::table('eva_eeconomica')->where('eva_eeconomica.responsable', '=', $request->cedula)->count();
                $financiera = DB::table('eva_efinanciera')->where('eva_efinanciera.responsable', '=', $request->cedula)->count();
                $ingenieria = DB::table('eva_eingdiseno')->where('eva_eingdiseno.responsable', '=', $request->cedula)->count();

                $rst = $legal + $economico + $financiera + $ingenieria;

                $msj = array();

                if($legal != 0){
                    $msj[] = '<li>Tiene '.$legal.' evaluación(es) legal</li>';
                }
                if($economico != 0){
                    $msj[] = '<li>Tiene '.$economico.' evaluación(es) económico-social</li>';
                }
                if($financiera != 0){
                    $msj[] = '<li>Tiene '.$financiera.' evaluación(es) financiera</li>';
                }
                if($ingenieria != 0){
                    $msj[] = '<li>Tiene '.$ingenieria.' evaluación(es) de ingenieria de diseño</li>';
                }


                if($rst == 0 ){
                    $deletedRows = DB::table('eva_responsables')->where('id', $request->id)->delete();
                    if ($deletedRows == 1) {
                        UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - RESPONSABLES', 'ELIMINAR - '.$request->cedula);
                        return response()->json(array(
                            'status' => 1,
                            'msg' => 'Registro eliminado',
                        ));
                    } else {
                        return response()->json(array(
                            'status' => 0,
                            'msg' => 'No se pudo eliminar el registro',
                        ));
                    }
                }
                else{
                    return response()->json(array(
                        'status' => 0,
                        'msg' => '<h3>No se puede eliminar el responsable porque:<br><br><ul class="text-danger text-ultra-bold">'. implode('', $msj) .'</ul></h3>'
                    ));
                }



               // $cedula = DB::table('eva_responsables')->select('cedula')->where('id', $request->id)->get();



            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => UtilidadesController::errorPostgres($e->getCode())
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }

    }

    public function activarDesactivarResponsable(Request $request)
    {
        try{
            if($request->ajax()) {

                $updResp = DB::table('eva_responsables')
                    ->where('id', $request->id)
                    ->update(
                        array(
                            'status' => ($request->status == 1) ? 0 : 1
                        )
                    );

                if($updResp){
                    UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - RESPONSABLES', 'ACTIVAR-DESACTIVAR - '.$request->cedula);

                    return response()->json(array(
                        'status' => 1,
                        'msg' => 'Registro actualizado',
                    ));
                }
                else{
                    return response()->json(array(
                        'status' => 0,
                        'msg' => 'No se pudo actualizar el registro',
                    ));
                }

            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => UtilidadesController::errorPostgres($e->getCode())
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }

    }

    public function getDataAsigProyectos(Request $request)
    {
        //dd($request->all());
        $mprima = DB::table('solicitudes')
            ->join('empresas', 'solicitudes.emp_rif', '=', 'empresas.rif')
            ->select('solicitudes.id',
                DB::raw("to_char(solicitudes.fecha, 'DD/MM/YYYY') as fecha"),
                'empresas.empresa',
                'solicitudes.emp_rif',
                'solicitudes.objeto',
                'solicitudes.obj_proyecto',
                'solicitudes.observacion',
                DB::raw("(select eva_elegal.verificado from eva_elegal where eva_elegal.sol_id = solicitudes.id) as el"),
                DB::raw("(select eva_eeconomica.verificado from eva_eeconomica where eva_eeconomica.sol_id = solicitudes.id) as ee"),
                DB::raw("(select eva_efinanciera.verificado from eva_efinanciera where eva_efinanciera.sol_id = solicitudes.id) as ef"),
                DB::raw("(select eva_eingdiseno.verificado from eva_eingdiseno where eva_eingdiseno.sol_id = solicitudes.id) as ei"),
                DB::raw("(select count(eva_asigeva.sol_id) from eva_asigeva where eva_asigeva.sol_id = solicitudes.id) as nasig")
            )->where('solicitudes.objeto', '=', 'PRESENTACIÓN DE PROYECTO');

        $datatable = Datatables::of($mprima)
            ->editColumn('obj_proyecto', function ($mp) {
                return wordwrap(str_replace('&nbsp;', ' ', $mp->obj_proyecto), 50, '<br>');
            })
            ->addColumn('accion', function ($mp) {
                $verf = '';
                $btn = '';
                $btn .= '<a href="javascript:void(0);" title="Asignar responsable" onclick="asigResponsable('.$mp->id.')"><i class="fa fa-user-plus fa-lg fa-border '.$verf.'"></i><sup class="badge style-info">'.$mp->nasig.'</sup></a> ';

                //<sup class="badge style-info">'.$mp->acciones.'</sup>

                return $btn;
            })
            ->filterColumn('solicitudes.fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(solicitudes.fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })
            ->rawColumns(['obj_proyecto','accion']);

        if ($datatable->request->get('fecha_inicio') && $datatable->request->get('fecha_fin') ) {
            //$datatable->where('solicitudes.fecha', '=', "$name%");
            $datatable->whereBetween('solicitudes.fecha', [ $datatable->request->get('fecha_inicio'), $datatable->request->get('fecha_fin') ]);
        }

        return $datatable->make(true);

    }

    public function getDataAsigEvaluacion(Request $request)
    {


        $data = DB::table('eva_asigeva')
            ->join('eva_responsables', 'eva_asigeva.resp_id', '=', 'eva_responsables.id')
            ->join('solicitudes', 'eva_asigeva.sol_id', '=', 'solicitudes.id')
            ->select(
                'eva_responsables.nombre',
                'eva_asigeva.evaluacion',
                DB::raw("to_char(eva_asigeva.created_at, 'DD/MM/YYYY') as fecha")
            )
            ->where('eva_asigeva.sol_id', $request->id)->get();

        $result = array();
        if(!empty($data)){
            foreach ($data as $t){
                array_push($result, array("nombre"=>$t->nombre, "evaluacion"=>$t->evaluacion, "fecha" => $t->fecha));
            }
        }
        else{
            array_push($result, array("nombre"=>'', "evaluacion"=>'', "fecha" => ''));
        }

        return response()->json($result);

    }

    public function agregarAsigEvaluacion(Request $request)
    {
        try{

            $data = DB::table('eva_asigeva')->select('eva_asigeva.id')->where([['sol_id',$request->sol_id],['evaluacion',$request->evaluacion]])->get();
            //dd($data[0]->id, $request->all());

            if(count($data) == 0){
                $resp = DB::table('eva_asigeva')->insert(
                    array(
                        'sol_id' => $request->sol_id,
                        'evaluacion' => mb_strtoupper($request->evaluacion, 'UTF-8'),
                        'resp_id' => $request->resp_id
                    )
                );
                UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - ASIGNAR RESPONSABLE', 'AGREGAR - '.$request->sol_id.' - '.$request->resp_id.' - '.$request->evaluacion);
                $msg = 'Registro agregado';
            }
            else{
                $resp = DB::table('eva_asigeva')
                    ->where('id', $data[0]->id)
                    ->update(
                        array(
                            'sol_id' => $request->sol_id,
                            'evaluacion' => mb_strtoupper($request->evaluacion, 'UTF-8'),
                            'resp_id' => $request->resp_id,
                            'updated_at' => DB::raw("now()")
                        )
                    );

                UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - ASIGNAR RESPONSABLE', 'ACTUALIZAR - '.$request->sol_id.' - '.$request->resp_id.' - '.$request->evaluacion);
                $msg = 'Registro actualizado';
            }

            if($resp){
                return response()->json(array(
                    'status' => 1,
                    'msg' => $msg,
                    'sol_id' => $request->sol_id
                ));
            }

        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
    }

    /*
     * evaluacion legal
     */


    public function getIndexLegal()
    {
        $resp = UtilidadesController::getEvaResp();
        return view('sistema.evaluacion.legal', compact('resp'));
    }

    public function getDataLegal(Request $request)
    {
        //dd($request->all());
        $mprima = DB::table('solicitudes')
            ->join('empresas', 'solicitudes.emp_rif', '=', 'empresas.rif')
            ->join('eva_asigeva', 'eva_asigeva.sol_id', '=', 'solicitudes.id')
            ->join('eva_responsables', 'eva_asigeva.resp_id', '=', 'eva_responsables.id')
            ->select('solicitudes.id',
                DB::raw("to_char(solicitudes.fecha, 'DD/MM/YYYY') as fecha"),
                'empresas.empresa',
                'solicitudes.emp_rif',
                'solicitudes.objeto',
                'solicitudes.obj_proyecto',
                'solicitudes.observacion',
                DB::raw("(select eva_elegal.verificado from eva_elegal where eva_elegal.sol_id = solicitudes.id) as verificado"),
                'eva_responsables.nombre',
                'eva_responsables.cedula'
               )->where([['solicitudes.objeto', '=', 'PRESENTACIÓN DE PROYECTO'],['eva_asigeva.evaluacion', '=', 'EVALUACION LEGAL']]);
        //dd($mprima);

        if(Auth::user()->rol == 41){
            $mprima->where('eva_responsables.cedula', '=', Auth::user()->cnd);
        }
/*
        if(Auth::user()->rol == 30){
            $mprima->where('solicitudes.emp_rif', 'ilike', Auth::user()->empresa);
        }
        if(Auth::user()->rol == 2){
            $mprima->where('empresas.usuario', '=', Auth::user()->id);
        }

        if(Auth::user()->rol == 5){
            $mprima->where('solicitudes.objeto', '=', 'FINANCIAMIENTO');
        }
        if ($request->fecha_inicio &&  $request->fecha_fin) {
            $mprima->whereBetween('solicitudes.fecha', [$request->fecha_inicio, $request->fecha_fin]);
        }*/

        /*,
            DB::raw('(select)')*/

        $datatable = Datatables::of($mprima)
            ->addColumn('accion', function ($mp) {
                $verf = ($mp->verificado == 'SI') ? 'style-success' : (($mp->verificado == 'NO') ? 'style-danger' : '');
                $btn = '';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 40 || Auth::user()->rol == 41) {
                    $btn .= '<a href="javascript:void(0);" title="Evaluación legal" onclick="addEvaLegal('.$mp->id.', '.$mp->cedula.',\''.$mp->nombre.'\')"><i class="fa fa-check-square-o fa-lg fa-border '.$verf.'"></i></a> ';

                }

                $btn .='<a href="javascript:void(0);" title="Detalle evaluacion legal" onclick="viewEvaLegal('.$mp->id.')"><i class="fa fa-eye fa-lg fa-border"></i></a>';

                if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 40){
                    $btn .= '<a href="javascript:void(0);" title="Reset evaluacion legal" onclick="delEvaLegal('.$mp->id.')"><i class="fa fa-refresh fa-lg fa-border"></i></a>';
                }

                //<sup class="badge style-info">'.$mp->acciones.'</sup>

                return $btn;
            })
            ->filterColumn('solicitudes.fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(solicitudes.fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })
            ->rawColumns(['accion']);

        if ($datatable->request->get('fecha_inicio') && $datatable->request->get('fecha_fin') ) {
            //$datatable->where('solicitudes.fecha', '=', "$name%");
            $datatable->whereBetween('solicitudes.fecha', [ $datatable->request->get('fecha_inicio'), $datatable->request->get('fecha_fin') ]);
        }

        return $datatable->make(true);

    }

    public function buscarEvaLegal(Request $request)
    {
        if($request->ajax()) {

            $evaLegal = DB::table('eva_elegal')
                //->join('eva_responsables', 'eva_responsables.cedula', '=', 'eva_elegal.responsable')
                ->select('eva_elegal.id',
                    'eva_elegal.sol_id',
                    'eva_elegal.fecha',
                    'eva_elegal.rif',
                    'eva_elegal.aconstitutiva',
                    'eva_elegal.rsocial',
                    'eva_elegal.item4',
                    'eva_elegal.item5',
                    'eva_elegal.item6',
                    'eva_elegal.item7',
                    'eva_elegal.item8',
                    'eva_elegal.item9',
                    'eva_elegal.item10',
                    'eva_elegal.item11',
                    'eva_elegal.item12',
                    'eva_elegal.item13',
                    'eva_elegal.responsable',
                    'eva_elegal.observacion',
                    'eva_elegal.verificado'/*,
                    'eva_responsables.cedula',
                    'eva_responsables.nombre'*/
                )
                ->where('eva_elegal.sol_id', '=', $request->id)->get();

            if(count($evaLegal) > 0){
                if($evaLegal[0]->verificado == 'SI'){
                    return response()->json(array('msj' => 'Ya se realizo la evaluación legal de este proyecto'));
                }
                else{
                    return response()->json(array('info' => $evaLegal, 'msj' => '0'));
                }
            }
            else{
                return response()->json(array('sol_id' => '0'));
            }

        }
    }

    public function agregarEvaLegal(Request $request)
    {
        try{
        if(empty($request->id_evalegal)){
                $resp = DB::table('eva_elegal')->insert(
                    array(
                        'fecha' => $request->fecha,
                        'rif' => mb_strtoupper($request->rif, 'UTF-8'),
                        'sol_id' => mb_strtoupper($request->id_sol, 'UTF-8'),
                        'aconstitutiva' => mb_strtoupper($request->aconstitutiva, 'UTF-8'),
                        'rsocial' => mb_strtoupper($request->rsocial, 'UTF-8'),
                        'observacion' => mb_strtoupper($request->observacion, 'UTF-8'),
                        'verificado' => mb_strtoupper($request->verificado, 'UTF-8'),
                        'responsable' => mb_strtoupper($request->responsable, 'UTF-8')
                    )
                );
                UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - LEGAL', 'AGREGAR - '.$request->id_sol);
                $msg = 'Registro agregado';
            }
            else{
                $resp = DB::table('eva_elegal')
                    ->where('id', $request->id_evalegal)
                    ->update(
                        array(
                            'fecha' => $request->fecha,
                            'rif' => mb_strtoupper($request->rif, 'UTF-8'),
                            'sol_id' => mb_strtoupper($request->id_sol, 'UTF-8'),
                            'aconstitutiva' => mb_strtoupper($request->aconstitutiva, 'UTF-8'),
                            'rsocial' => mb_strtoupper($request->rsocial, 'UTF-8'),
                            'observacion' => mb_strtoupper($request->observacion, 'UTF-8'),
                            'verificado' => mb_strtoupper($request->verificado, 'UTF-8'),
                            'responsable' => mb_strtoupper($request->responsable, 'UTF-8'),
                            'updated_at' => DB::raw("now()")
                        )
                    );

                UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - LEGAL', 'ACTUALIZAR - '.$request->id_sol);
                $msg = 'Registro actualizado';
            }

            if($resp){
                return response()->json(array(
                    'status' => 1,
                    'msg' => $msg,
                ));
            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
    }

    public function verEvaLegal(Request $request)
    {
        if($request->ajax()) {

            $evaLegal = DB::table('eva_elegal')
                ->join('eva_responsables', 'eva_responsables.cedula', '=', 'eva_elegal.responsable')
                ->select('eva_elegal.id',
                    'eva_elegal.sol_id',
                    DB::raw("to_char(eva_elegal.fecha, 'DD/MM/YYYY') as fecha"),
                    DB::raw("to_char(eva_elegal.updated_at, 'DD/MM/YYYY') as actualizacion"),
                    'eva_elegal.rif',
                    'eva_elegal.aconstitutiva',
                    'eva_elegal.rsocial',
                    'eva_elegal.item4',
                    'eva_elegal.item5',
                    'eva_elegal.item6',
                    'eva_elegal.item7',
                    'eva_elegal.item8',
                    'eva_elegal.item9',
                    'eva_elegal.item10',
                    'eva_elegal.item11',
                    'eva_elegal.item12',
                    'eva_elegal.item13',
                    'eva_elegal.responsable',
                    'eva_elegal.observacion',
                    'eva_elegal.verificado',
                    'eva_responsables.nombre'
                )
                ->where('eva_elegal.sol_id', '=', $request->id)->get();

                return response()->json(array('info' => $evaLegal, 'msj' => '0'));

        }
    }

    public function eliminarEvaLegal(Request $request)
    {
        try{
            if($request->ajax()) {
                //$cedula = DB::table('eva_responsables')->select('cedula')->where('id', $request->id)->get();

                $economico = DB::table('eva_eeconomica')->where('eva_eeconomica.sol_id', '=', $request->id)->count();
                $financiera = DB::table('eva_efinanciera')->where('eva_efinanciera.sol_id', '=', $request->id)->count();
                $ingenieria = DB::table('eva_eingdiseno')->where('eva_eingdiseno.sol_id', '=', $request->id)->count();

                $rst = $economico + $financiera + $ingenieria;

                $msj = array();

                if($economico != 0){
                    $msj[] = '<li>Tiene evaluación económico-social</li>';
                }
                if($financiera != 0){
                    $msj[] = '<li>Tiene evaluación financiera</li>';
                }
                if($ingenieria != 0){
                    $msj[] = '<li>Tiene evaluación de ingenieria de diseño</li>';
                }

                if($rst == 0 ){
                    $deletedRows = DB::table('eva_elegal')->where('eva_elegal.sol_id', $request->id)->delete();
                    if ($deletedRows == 1) {
                        UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - LEGAL', 'ELIMINAR - '.$request->id);
                        return response()->json(array(
                            'status' => 1,
                            'msg' => 'Registro actualizado',
                        ));
                    } else {
                        return response()->json(array(
                            'status' => 0,
                            'msg' => 'No se pudo eliminar el actualizar',
                        ));
                    }
                }
                else{
                    return response()->json(array(
                        'status' => 0,
                        'msg' => '<h3>No se puede resetear la evaluación del proyecto porque:<br><br><ul class="text-danger text-ultra-bold">'. implode('', $msj) .'</ul>Debe resetear las otras evaluaciones primero</h3>'
                    ));
                }

            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => UtilidadesController::errorPostgres($e->getCode())
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }

    }

    /*
     * evaluacion economico-social
     */

    public function getIndexEcomonica()
    {
        $resp = UtilidadesController::getEvaResp('ECONOMICA');
        return view('sistema.evaluacion.economico', compact('resp'));
    }

    public function getDataEconomica(Request $request)
    {
        //dd($request->all());
        $mprima = DB::table('solicitudes')
            ->join('empresas', 'solicitudes.emp_rif', '=', 'empresas.rif')
            ->join('eva_asigeva', 'eva_asigeva.sol_id', '=', 'solicitudes.id')
            ->join('eva_responsables', 'eva_asigeva.resp_id', '=', 'eva_responsables.id')
            ->select('solicitudes.id',
                DB::raw("to_char(solicitudes.fecha, 'DD/MM/YYYY') as fecha"),
                'empresas.empresa',
                'solicitudes.emp_rif',
                'solicitudes.objeto',
                'solicitudes.obj_proyecto',
                'solicitudes.observacion',
                DB::raw("(select eva_eeconomica.verificado from eva_eeconomica where eva_eeconomica.sol_id = solicitudes.id) as verificado"),
                'eva_responsables.nombre',
                'eva_responsables.cedula'
            )
            ->where('eva_asigeva.evaluacion', '=', 'EVALUACION ECONOMICO-SOCIAL')
            ->whereRaw("(select eva_elegal.verificado from eva_elegal where eva_elegal.sol_id = solicitudes.id) = 'SI'");

        if(Auth::user()->rol == 42){
            $mprima->where('eva_responsables.cedula', '=', Auth::user()->cnd);
        }

        //dd($mprima);
        /*if(Auth::user()->rol == 30){
            $mprima->where('solicitudes.emp_rif', 'ilike', Auth::user()->empresa);
        }
        if(Auth::user()->rol == 2){
            $mprima->where('empresas.usuario', '=', Auth::user()->id);
        }

        if(Auth::user()->rol == 5){
            $mprima->where('solicitudes.objeto', '=', 'FINANCIAMIENTO');
        }
        if ($request->fecha_inicio &&  $request->fecha_fin) {
            $mprima->whereBetween('solicitudes.fecha', [$request->fecha_inicio, $request->fecha_fin]);
        }*/

        /*,
            DB::raw('(select)')*/

        $datatable = Datatables::of($mprima)
            ->addColumn('accion', function ($mp) {
                $verf = ($mp->verificado == 'SI') ? 'style-success' : (($mp->verificado == 'NO') ? 'style-danger' : '');
                $btn = '';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 40 || Auth::user()->rol == 42 ) {
                    $btn .= '<a href="javascript:void(0);" title="Evaluación económica" onclick="addEvaEconomica('.$mp->id.', '.$mp->cedula.',\''.$mp->nombre.'\')"><i class="fa fa-check-square-o fa-lg fa-border '.$verf.'"></i></a> ';

                }

                $btn .='<a href="javascript:void(0);" title="Detalle evaluacion económica" onclick="viewEvaEconomica('.$mp->id.')"><i class="fa fa-eye fa-lg fa-border"></i></a>';

                if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 40){
                    $btn .= '<a href="javascript:void(0);" title="Reset evaluacion económica" onclick="delEvaEconomica('.$mp->id.')"><i class="fa fa-refresh fa-lg fa-border"></i></a>';
                }

                //<sup class="badge style-info">'.$mp->acciones.'</sup>

                return $btn;
            })
            ->filterColumn('solicitudes.fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(solicitudes.fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })
            ->rawColumns(['accion']);

        if ($datatable->request->get('fecha_inicio') && $datatable->request->get('fecha_fin') ) {
            //$datatable->where('solicitudes.fecha', '=', "$name%");
            $datatable->whereBetween('solicitudes.fecha', [ $datatable->request->get('fecha_inicio'), $datatable->request->get('fecha_fin') ]);
        }

        return $datatable->make(true);

    }

    public function buscarEvaEconomica(Request $request)
    {
        if($request->ajax()) {

            $evaEconomica = DB::table('eva_eeconomica')
                ->join('eva_responsables', 'eva_responsables.cedula', '=', 'eva_eeconomica.responsable')
                ->select('eva_eeconomica.id',
                    'eva_eeconomica.sol_id',
                    'eva_eeconomica.fecha',
                    'eva_eeconomica.justificacion',
                    'eva_eeconomica.emercado',
                    'eva_eeconomica.pinversion',
                    'eva_eeconomica.fcaja',
                    'eva_eeconomica.cuae',
                    'eva_eeconomica.van',
                    'eva_eeconomica.tir',
                    'eva_eeconomica.item8',
                    'eva_eeconomica.item9',
                    'eva_eeconomica.item10',
                    'eva_eeconomica.item11',
                    'eva_eeconomica.item12',
                    'eva_eeconomica.item13',
                    'eva_eeconomica.responsable',
                    'eva_eeconomica.observacion',
                    'eva_eeconomica.verificado',
                    'eva_responsables.cedula',
                    'eva_responsables.nombre'
                )
                ->where('eva_eeconomica.sol_id', '=', $request->id)->get();

            if(count($evaEconomica) > 0){
                if($evaEconomica[0]->verificado == 'SI'){
                    return response()->json(array('msj' => 'Ya se realizo la evaluación económico-social de este proyecto'));
                }
                else{
                    return response()->json(array('info' => $evaEconomica, 'msj' => '0'));
                }
            }
            else{
                return response()->json(array('sol_id' => '0'));
            }

        }
    }

    public function agregarEvaEconomica(Request $request)
    {
        try{
            if(empty($request->id_evaeconomica)){
                $resp = DB::table('eva_eeconomica')->insert(
                    array(
                        'fecha' => $request->fecha,
                        'sol_id' => mb_strtoupper($request->id_sol, 'UTF-8'),

                        'justificacion' => mb_strtoupper($request->justificacion, 'UTF-8'),
                        'emercado' => mb_strtoupper($request->emercado, 'UTF-8'),
                        'pinversion' => mb_strtoupper($request->pinversion, 'UTF-8'),
                        'fcaja' => mb_strtoupper($request->fcaja, 'UTF-8'),
                        'cuae' => mb_strtoupper($request->cuae, 'UTF-8'),
                        'van' => mb_strtoupper($request->van, 'UTF-8'),
                        'tir' => mb_strtoupper($request->tir, 'UTF-8'),
                        'observacion' => mb_strtoupper($request->observacion, 'UTF-8'),
                        'verificado' => mb_strtoupper($request->verificado, 'UTF-8'),
                        'responsable' => mb_strtoupper($request->responsable, 'UTF-8')
                    )
                );
                UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - ECONOMICO-SOCIAL', 'AGREGAR - '.$request->id_sol);
                $msg = 'Registro agregado';
            }
            else{
                $resp = DB::table('eva_eeconomica')
                    ->where('id', $request->id_evaeconomica)
                    ->update(
                        array(
                            'fecha' => $request->fecha,
                            'sol_id' => mb_strtoupper($request->id_sol, 'UTF-8'),
                            'justificacion' => mb_strtoupper($request->justificacion, 'UTF-8'),
                            'emercado' => mb_strtoupper($request->emercado, 'UTF-8'),
                            'pinversion' => mb_strtoupper($request->pinversion, 'UTF-8'),
                            'fcaja' => mb_strtoupper($request->fcaja, 'UTF-8'),
                            'cuae' => mb_strtoupper($request->cuae, 'UTF-8'),
                            'van' => mb_strtoupper($request->van, 'UTF-8'),
                            'tir' => mb_strtoupper($request->tir, 'UTF-8'),
                            'observacion' => mb_strtoupper($request->observacion, 'UTF-8'),
                            'verificado' => mb_strtoupper($request->verificado, 'UTF-8'),
                            'responsable' => mb_strtoupper($request->responsable, 'UTF-8'),
                            'updated_at' => DB::raw("now()")
                        )
                    );

                UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - ECONOMICO-SOCIAL', 'ACTUALIZAR - '.$request->id_sol);
                $msg = 'Registro actualizado';
            }

            if($resp){
                return response()->json(array(
                    'status' => 1,
                    'msg' => $msg,
                ));
            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
    }

    public function verEvaEconomica(Request $request)
    {
        if($request->ajax()) {

            $evaEconomica = DB::table('eva_eeconomica')
                ->join('eva_responsables', 'eva_responsables.cedula', '=', 'eva_eeconomica.responsable')
                ->select('eva_eeconomica.id',
                    'eva_eeconomica.sol_id',
                    DB::raw("to_char(eva_eeconomica.fecha, 'DD/MM/YYYY') as fecha"),
                    DB::raw("to_char(eva_eeconomica.updated_at, 'DD/MM/YYYY') as actualizacion"),
                    'eva_eeconomica.justificacion',
                    'eva_eeconomica.emercado',
                    'eva_eeconomica.pinversion',
                    'eva_eeconomica.fcaja',
                    'eva_eeconomica.cuae',
                    'eva_eeconomica.van',
                    'eva_eeconomica.tir',
                    'eva_eeconomica.item8',
                    'eva_eeconomica.item9',
                    'eva_eeconomica.item10',
                    'eva_eeconomica.item11',
                    'eva_eeconomica.item12',
                    'eva_eeconomica.item13',
                    'eva_eeconomica.responsable',
                    'eva_eeconomica.observacion',
                    'eva_eeconomica.verificado',
                    'eva_responsables.cedula',
                    'eva_responsables.nombre'
                )
                ->where('eva_eeconomica.sol_id', '=', $request->id)->get();

            return response()->json(array('info' => $evaEconomica, 'msj' => '0'));

        }
    }

    public function eliminarEvaEconomica(Request $request)
    {
        try{
            if($request->ajax()) {
                //$cedula = DB::table('eva_responsables')->select('cedula')->where('id', $request->id)->get();
                $financiera = DB::table('eva_efinanciera')->where('eva_efinanciera.sol_id', '=', $request->id)->count();
                $ingenieria = DB::table('eva_eingdiseno')->where('eva_eingdiseno.sol_id', '=', $request->id)->count();

                $rst = $financiera + $ingenieria;

                $msj = array();

                if($financiera != 0){
                    $msj[] = '<li>Tiene evaluación financiera</li>';
                }
                if($ingenieria != 0){
                    $msj[] = '<li>Tiene evaluación de ingenieria de diseño</li>';
                }

                if($rst == 0 ){
                    $deletedRows = DB::table('eva_eeconomica')->where('eva_eeconomica.sol_id', $request->id)->delete();
                    if ($deletedRows == 1) {
                        UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - ECONOMICO-SOCIAL', 'ELIMINAR - '.$request->id);
                        return response()->json(array(
                            'status' => 1,
                            'msg' => 'Registro actualizado',
                        ));
                    } else {
                        return response()->json(array(
                            'status' => 0,
                            'msg' => 'No se pudo eliminar el actualizar',
                        ));
                    }
                }
                else{
                    return response()->json(array(
                        'status' => 0,
                        'msg' => '<h3>No se puede resetear la evaluación del proyecto porque:<br><br><ul class="text-danger text-ultra-bold">'. implode('', $msj) .'</ul>Debe resetear las otras evaluaciones primero</h3>'
                    ));
                }
            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => UtilidadesController::errorPostgres($e->getCode())
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }

    }

    /*
     * evaluacion financiera
     */

    public function getIndexFinanciera()
    {
        $resp = UtilidadesController::getEvaResp('FINANCIERA');
        return view('sistema.evaluacion.financiera', compact('resp'));
    }

    public function getDataFinanciera(Request $request)
    {
        //dd($request->all());
        $mprima = DB::table('solicitudes')
            ->join('empresas', 'solicitudes.emp_rif', '=', 'empresas.rif')
            ->join('eva_asigeva', 'eva_asigeva.sol_id', '=', 'solicitudes.id')
            ->join('eva_responsables', 'eva_asigeva.resp_id', '=', 'eva_responsables.id')
            ->select('solicitudes.id',
                DB::raw("to_char(solicitudes.fecha, 'DD/MM/YYYY') as fecha"),
                'empresas.empresa',
                'solicitudes.emp_rif',
                'solicitudes.objeto',
                'solicitudes.obj_proyecto',
                'solicitudes.observacion',
                DB::raw("(select eva_efinanciera.verificado from eva_efinanciera where eva_efinanciera.sol_id = solicitudes.id) as verificado"),
                'eva_responsables.nombre',
                'eva_responsables.cedula'
            )
            ->where('eva_asigeva.evaluacion', '=', 'EVALUACION FINANCIERA')
            ->whereRaw("(select eva_eeconomica.verificado from eva_eeconomica where eva_eeconomica.sol_id = solicitudes.id) = 'SI'");
        if(Auth::user()->rol == 43){
            $mprima->where('eva_responsables.cedula', '=', Auth::user()->cnd);
        }
        //dd($mprima);
        /*if(Auth::user()->rol == 30){
            $mprima->where('solicitudes.emp_rif', 'ilike', Auth::user()->empresa);
        }
        if(Auth::user()->rol == 2){
            $mprima->where('empresas.usuario', '=', Auth::user()->id);
        }

        if(Auth::user()->rol == 5){
            $mprima->where('solicitudes.objeto', '=', 'FINANCIAMIENTO');
        }
        if ($request->fecha_inicio &&  $request->fecha_fin) {
            $mprima->whereBetween('solicitudes.fecha', [$request->fecha_inicio, $request->fecha_fin]);
        }*/

        /*,
            DB::raw('(select)')*/

        $datatable = Datatables::of($mprima)
            ->addColumn('accion', function ($mp) {
                $verf = ($mp->verificado == 'SI') ? 'style-success' : (($mp->verificado == 'NO') ? 'style-danger' : '');
                $btn = '';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 40 || Auth::user()->rol == 43) {
                    $btn .= '<a href="javascript:void(0);" title="Evaluación económica" onclick="addEvaFinanciera('.$mp->id.', '.$mp->cedula.',\''.$mp->nombre.'\')"><i class="fa fa-check-square-o fa-lg fa-border '.$verf.'"></i></a> ';

                }

                $btn .='<a href="javascript:void(0);" title="Detalle evaluacion económica" onclick="viewEvaFinanciera('.$mp->id.')"><i class="fa fa-eye fa-lg fa-border"></i></a>';

                if(Auth::user()->rol == 10 || Auth::user()->rol == 1  || Auth::user()->rol == 40){
                    $btn .= '<a href="javascript:void(0);" title="Reset evaluacion económica" onclick="delEvaFinanciera('.$mp->id.')"><i class="fa fa-refresh fa-lg fa-border"></i></a>';
                }

                //<sup class="badge style-info">'.$mp->acciones.'</sup>

                return $btn;
            })
            ->filterColumn('solicitudes.fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(solicitudes.fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })
            ->rawColumns(['accion']);

        if ($datatable->request->get('fecha_inicio') && $datatable->request->get('fecha_fin') ) {
            //$datatable->where('solicitudes.fecha', '=', "$name%");
            $datatable->whereBetween('solicitudes.fecha', [ $datatable->request->get('fecha_inicio'), $datatable->request->get('fecha_fin') ]);
        }

        return $datatable->make(true);

    }

    public function buscarEvaFinanciera(Request $request)
    {
        if($request->ajax()) {

            $evaFinanciera = DB::table('eva_efinanciera')
                ->join('eva_responsables', 'eva_responsables.cedula', '=', 'eva_efinanciera.responsable')
                ->select('eva_efinanciera.id',
                    'eva_efinanciera.sol_id',
                    'eva_efinanciera.fecha',
                    'eva_efinanciera.afinanciero',
                    'eva_efinanciera.cproduccion',
                    'eva_efinanciera.gadminventas',
                    'eva_efinanciera.ingresos',
                    'eva_efinanciera.efinancieros',
                    'eva_efinanciera.acostos',
                    'eva_efinanciera.item7',
                    'eva_efinanciera.item8',
                    'eva_efinanciera.item9',
                    'eva_efinanciera.item10',
                    'eva_efinanciera.item11',
                    'eva_efinanciera.item12',
                    'eva_efinanciera.item13',
                    'eva_efinanciera.responsable',
                    'eva_efinanciera.observacion',
                    'eva_efinanciera.verificado',
                    'eva_responsables.cedula',
                    'eva_responsables.nombre'
                )
                ->where('eva_efinanciera.sol_id', '=', $request->id)->get();

            if(count($evaFinanciera) > 0){
                if($evaFinanciera[0]->verificado == 'SI'){
                    return response()->json(array('msj' => 'Ya se realizo la evaluación financiera de este proyecto'));
                }
                else{
                    return response()->json(array('info' => $evaFinanciera, 'msj' => '0'));
                }
            }
            else{
                return response()->json(array('sol_id' => '0'));
            }

        }
    }

    public function agregarEvaFinanciera(Request $request)
    {
        try{
            if(empty($request->id_evafinanciera)){
                $resp = DB::table('eva_efinanciera')->insert(
                    array(
                        'fecha' => $request->fecha,
                        'sol_id' => mb_strtoupper($request->id_sol, 'UTF-8'),

                        'afinanciero' => mb_strtoupper($request->afinanciero, 'UTF-8'),
                        'cproduccion' => mb_strtoupper($request->cproduccion, 'UTF-8'),
                        'gadminventas' => mb_strtoupper($request->gadminventas, 'UTF-8'),
                        'ingresos' => mb_strtoupper($request->ingresos, 'UTF-8'),
                        'efinancieros' => mb_strtoupper($request->efinancieros, 'UTF-8'),
                        'acostos' => mb_strtoupper($request->acostos, 'UTF-8'),
                        'observacion' => mb_strtoupper($request->observacion, 'UTF-8'),
                        'verificado' => mb_strtoupper($request->verificado, 'UTF-8'),
                        'responsable' => mb_strtoupper($request->responsable, 'UTF-8')
                    )
                );
                UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - FINANCIERA', 'AGREGAR - '.$request->id_sol);
                $msg = 'Registro agregado';
            }
            else{
                $resp = DB::table('eva_efinanciera')
                    ->where('id', $request->id_evafinanciera)
                    ->update(
                        array(
                            'fecha' => $request->fecha,
                            'sol_id' => mb_strtoupper($request->id_sol, 'UTF-8'),
                            'afinanciero' => mb_strtoupper($request->afinanciero, 'UTF-8'),
                            'cproduccion' => mb_strtoupper($request->cproduccion, 'UTF-8'),
                            'gadminventas' => mb_strtoupper($request->gadminventas, 'UTF-8'),
                            'ingresos' => mb_strtoupper($request->ingresos, 'UTF-8'),
                            'efinancieros' => mb_strtoupper($request->efinancieros, 'UTF-8'),
                            'acostos' => mb_strtoupper($request->acostos, 'UTF-8'),
                            'observacion' => mb_strtoupper($request->observacion, 'UTF-8'),
                            'verificado' => mb_strtoupper($request->verificado, 'UTF-8'),
                            'responsable' => mb_strtoupper($request->responsable, 'UTF-8'),
                            'updated_at' => DB::raw("now()")
                        )
                    );

                UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - FINANCIERA', 'ACTUALIZAR - '.$request->id_sol);
                $msg = 'Registro actualizado';
            }

            if($resp){
                return response()->json(array(
                    'status' => 1,
                    'msg' => $msg,
                ));
            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
    }

    public function verEvaFinanciera(Request $request)
    {
        if($request->ajax()) {

            $evaFinanciera = DB::table('eva_efinanciera')
                ->join('eva_responsables', 'eva_responsables.cedula', '=', 'eva_efinanciera.responsable')
                ->select('eva_efinanciera.id',
                    'eva_efinanciera.sol_id',
                    DB::raw("to_char(eva_efinanciera.fecha, 'DD/MM/YYYY') as fecha"),
                    DB::raw("to_char(eva_efinanciera.updated_at, 'DD/MM/YYYY') as actualizacion"),
                    'eva_efinanciera.afinanciero',
                    'eva_efinanciera.cproduccion',
                    'eva_efinanciera.gadminventas',
                    'eva_efinanciera.ingresos',
                    'eva_efinanciera.efinancieros',
                    'eva_efinanciera.acostos',
                    'eva_efinanciera.item7',
                    'eva_efinanciera.item8',
                    'eva_efinanciera.item9',
                    'eva_efinanciera.item10',
                    'eva_efinanciera.item11',
                    'eva_efinanciera.item12',
                    'eva_efinanciera.item13',
                    'eva_efinanciera.responsable',
                    'eva_efinanciera.observacion',
                    'eva_efinanciera.verificado',
                    'eva_responsables.cedula',
                    'eva_responsables.nombre'
                )
                ->where('eva_efinanciera.sol_id', '=', $request->id)->get();



            return response()->json(array('info' => $evaFinanciera, 'msj' => '0'));

        }
    }

    public function eliminarEvaFinanciera(Request $request)
    {
        try{
            if($request->ajax()) {
                //$cedula = DB::table('eva_responsables')->select('cedula')->where('id', $request->id)->get();
                $ingenieria = DB::table('eva_eingdiseno')->where('eva_eingdiseno.sol_id', '=', $request->id)->count();

                $rst = $ingenieria;

                $msj = array();

                if($ingenieria != 0){
                    $msj[] = '<li>Tiene evaluación de ingenieria de diseño</li>';
                }

                if($rst == 0 ){
                    $deletedRows = DB::table('eva_efinanciera')->where('eva_efinanciera.sol_id', $request->id)->delete();
                    if ($deletedRows == 1) {
                        UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - FINANCIERA', 'ELIMINAR - '.$request->id);
                        return response()->json(array(
                            'status' => 1,
                            'msg' => 'Registro actualizado',
                        ));
                    } else {
                        return response()->json(array(
                            'status' => 0,
                            'msg' => 'No se pudo eliminar el actualizar',
                        ));
                    }
                }
                else{
                    return response()->json(array(
                        'status' => 0,
                        'msg' => '<h3>No se puede resetear la evaluación del proyecto porque:<br><br><ul class="text-danger text-ultra-bold">'. implode('', $msj) .'</ul>Debe resetear las otras evaluaciones primero</h3>'
                    ));
                }
            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => UtilidadesController::errorPostgres($e->getCode())
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }

    }

    /*
     * evaluacion ingenieria
     */

    public function getIndexIngenieria()
    {
        $resp = UtilidadesController::getEvaResp('INGENIERIA');
        return view('sistema.evaluacion.ingenieria', compact('resp'));
    }

    public function getDataIngenieria(Request $request)
    {
        //dd($request->all());
        $mprima = DB::table('solicitudes')
            ->join('empresas', 'solicitudes.emp_rif', '=', 'empresas.rif')
            ->join('eva_asigeva', 'eva_asigeva.sol_id', '=', 'solicitudes.id')
            ->join('eva_responsables', 'eva_asigeva.resp_id', '=', 'eva_responsables.id')
            ->select('solicitudes.id',
                DB::raw("to_char(solicitudes.fecha, 'DD/MM/YYYY') as fecha"),
                'empresas.empresa',
                'solicitudes.emp_rif',
                'solicitudes.objeto',
                'solicitudes.obj_proyecto',
                'solicitudes.observacion',
                DB::raw("(select eva_eingdiseno.verificado from eva_eingdiseno where eva_eingdiseno.sol_id = solicitudes.id) as verificado"),
                'eva_responsables.nombre',
                'eva_responsables.cedula'
            )
            ->where('eva_asigeva.evaluacion', '=', 'EVALUACION DE INGENIERIA DE DISEÑO')
            ->whereRaw("(select eva_efinanciera.verificado from eva_efinanciera where eva_efinanciera.sol_id = solicitudes.id) = 'SI'");

        if(Auth::user()->rol == 44){
            $mprima->where('eva_responsables.cedula', '=', Auth::user()->cnd);
        }
        //dd($mprima);
        /*if(Auth::user()->rol == 30){
            $mprima->where('solicitudes.emp_rif', 'ilike', Auth::user()->empresa);
        }
        if(Auth::user()->rol == 2){
            $mprima->where('empresas.usuario', '=', Auth::user()->id);
        }

        if(Auth::user()->rol == 5){
            $mprima->where('solicitudes.objeto', '=', 'FINANCIAMIENTO');
        }
        if ($request->fecha_inicio &&  $request->fecha_fin) {
            $mprima->whereBetween('solicitudes.fecha', [$request->fecha_inicio, $request->fecha_fin]);
        }*/

        /*,
            DB::raw('(select)')*/

        $datatable = Datatables::of($mprima)
            ->addColumn('accion', function ($mp) {
                $verf = ($mp->verificado == 'SI') ? 'style-success' : (($mp->verificado == 'NO') ? 'style-danger' : '');
                $btn = '';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 40 || Auth::user()->rol == 44) {
                    $btn .= '<a href="javascript:void(0);" title="Evaluación económica" onclick="addEvaIngenieria('.$mp->id.', '.$mp->cedula.',\''.$mp->nombre.'\')"><i class="fa fa-check-square-o fa-lg fa-border '.$verf.'"></i></a> ';

                }

                $btn .='<a href="javascript:void(0);" title="Detalle evaluacion económica" onclick="viewEvaIngenieria('.$mp->id.')"><i class="fa fa-eye fa-lg fa-border"></i></a>';

                if(Auth::user()->rol == 10 || Auth::user()->rol == 1  || Auth::user()->rol == 40){
                    $btn .= '<a href="javascript:void(0);" title="Reset evaluacion económica" onclick="delEvaIngenieria('.$mp->id.')"><i class="fa fa-refresh fa-lg fa-border"></i></a>';
                }

                //<sup class="badge style-info">'.$mp->acciones.'</sup>

                return $btn;
            })
            ->filterColumn('solicitudes.fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(solicitudes.fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })
            ->rawColumns(['accion']);

        if ($datatable->request->get('fecha_inicio') && $datatable->request->get('fecha_fin') ) {
            //$datatable->where('solicitudes.fecha', '=', "$name%");
            $datatable->whereBetween('solicitudes.fecha', [ $datatable->request->get('fecha_inicio'), $datatable->request->get('fecha_fin') ]);
        }

        return $datatable->make(true);

    }

    public function buscarEvaIngenieria(Request $request)
    {
        if($request->ajax()) {

            $evaIngenieria = DB::table('eva_eingdiseno')
                ->join('eva_responsables', 'eva_responsables.cedula', '=', 'eva_eingdiseno.responsable')
                ->select('eva_eingdiseno.id',
                    'eva_eingdiseno.sol_id',
                    'eva_eingdiseno.fecha',
                    'eva_eingdiseno.mdescriptiva',
                    'eva_eingdiseno.planos',
                    'eva_eingdiseno.computos',
                    'eva_eingdiseno.otros',
                    'eva_eingdiseno.item5',
                    'eva_eingdiseno.item6',
                    'eva_eingdiseno.item7',
                    'eva_eingdiseno.item8',
                    'eva_eingdiseno.item9',
                    'eva_eingdiseno.item10',
                    'eva_eingdiseno.item11',
                    'eva_eingdiseno.item12',
                    'eva_eingdiseno.item13',
                    'eva_eingdiseno.responsable',
                    'eva_eingdiseno.observacion',
                    'eva_eingdiseno.verificado',
                    'eva_responsables.cedula',
                    'eva_responsables.nombre'
                )
                ->where('eva_eingdiseno.sol_id', '=', $request->id)->get();

            if(count($evaIngenieria) > 0){
                if($evaIngenieria[0]->verificado == 'SI'){
                    return response()->json(array('msj' => 'Ya se realizo la evaluación financiera de este proyecto'));
                }
                else{
                    return response()->json(array('info' => $evaIngenieria, 'msj' => '0'));
                }
            }
            else{
                return response()->json(array('sol_id' => '0'));
            }

        }
    }

    public function agregarEvaIngenieria(Request $request)
    {
        try{
            if(empty($request->id_evaingenieria)){
                $resp = DB::table('eva_eingdiseno')->insert(
                    array(
                        'fecha' => $request->fecha,
                        'sol_id' => mb_strtoupper($request->id_sol, 'UTF-8'),

                        'mdescriptiva' => mb_strtoupper($request->mdescriptiva, 'UTF-8'),
                        'planos' => mb_strtoupper($request->planos, 'UTF-8'),
                        'computos' => mb_strtoupper($request->computos, 'UTF-8'),
                        'otros' => mb_strtoupper($request->otros, 'UTF-8'),
                        'observacion' => mb_strtoupper($request->observacion, 'UTF-8'),
                        'verificado' => mb_strtoupper($request->verificado, 'UTF-8'),
                        'responsable' => mb_strtoupper($request->responsable, 'UTF-8')
                    )
                );
                UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - INGENIERIA', 'AGREGAR - '.$request->id_sol);
                $msg = 'Registro agregado';
            }
            else{
                $resp = DB::table('eva_eingdiseno')
                    ->where('id', $request->id_evaingenieria)
                    ->update(
                        array(
                            'fecha' => $request->fecha,
                            'sol_id' => mb_strtoupper($request->id_sol, 'UTF-8'),
                            'mdescriptiva' => mb_strtoupper($request->mdescriptiva, 'UTF-8'),
                            'planos' => mb_strtoupper($request->planos, 'UTF-8'),
                            'computos' => mb_strtoupper($request->computos, 'UTF-8'),
                            'otros' => mb_strtoupper($request->otros, 'UTF-8'),
                            'observacion' => mb_strtoupper($request->observacion, 'UTF-8'),
                            'verificado' => mb_strtoupper($request->verificado, 'UTF-8'),
                            'responsable' => mb_strtoupper($request->responsable, 'UTF-8'),
                            'updated_at' => DB::raw("now()")
                        )
                    );

                UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - INGENIERIA', 'ACTUALIZAR - '.$request->id_sol);
                $msg = 'Registro actualizado';
            }

            if($resp){
                return response()->json(array(
                    'status' => 1,
                    'msg' => $msg,
                ));
            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
    }

    public function verEvaIngenieria(Request $request)
    {
        if($request->ajax()) {

            $evaIngenieria = DB::table('eva_eingdiseno')
                ->join('eva_responsables', 'eva_responsables.cedula', '=', 'eva_eingdiseno.responsable')
                ->select('eva_eingdiseno.id',
                    'eva_eingdiseno.sol_id',
                    DB::raw("to_char(eva_eingdiseno.fecha, 'DD/MM/YYYY') as fecha"),
                    DB::raw("to_char(eva_eingdiseno.updated_at, 'DD/MM/YYYY') as actualizacion"),
                    'eva_eingdiseno.mdescriptiva',
                    'eva_eingdiseno.planos',
                    'eva_eingdiseno.computos',
                    'eva_eingdiseno.otros',
                    'eva_eingdiseno.item5',
                    'eva_eingdiseno.item6',
                    'eva_eingdiseno.item7',
                    'eva_eingdiseno.item8',
                    'eva_eingdiseno.item9',
                    'eva_eingdiseno.item10',
                    'eva_eingdiseno.item11',
                    'eva_eingdiseno.item12',
                    'eva_eingdiseno.item13',
                    'eva_eingdiseno.responsable',
                    'eva_eingdiseno.observacion',
                    'eva_eingdiseno.verificado',
                    'eva_responsables.cedula',
                    'eva_responsables.nombre'
                )
                ->where('eva_eingdiseno.sol_id', '=', $request->id)->get();



            return response()->json(array('info' => $evaIngenieria, 'msj' => '0'));

        }
    }

    public function eliminarEvaIngenieria(Request $request)
    {
        try{
            if($request->ajax()) {
                //$cedula = DB::table('eva_responsables')->select('cedula')->where('id', $request->id)->get();

                $deletedRows = DB::table('eva_eingdiseno')->where('eva_eingdiseno.sol_id', $request->id)->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'EVALUACION DE PROYECTO - INGENIERIA', 'ELIMINAR - '.$request->id);
                    return response()->json(array(
                        'status' => 1,
                        'msg' => 'Registro actualizado',
                    ));
                } else {
                    return response()->json(array(
                        'status' => 0,
                        'msg' => 'No se pudo eliminar el actualizar',
                    ));
                }

            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => UtilidadesController::errorPostgres($e->getCode())
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }

    }

    /*
     * reportes
     */

    public function getIndexReportes()
    {
        //$resp = UtilidadesController::getEvaResp('INGENIERIA');, compact('resp')
        return view('sistema.evaluacion.reportes');
    }

    public function getReporteEvaluacionEnModuloSA(Request $request)
    {
        try{
            if ($request->ajax()) {

                    $legal = DB::table('eva_elegal')->join('eva_asigeva', 'eva_asigeva.sol_id', '=', 'eva_elegal.sol_id')->select(DB::raw('1 as id'),DB::raw("'LEGAL' as eva"),DB::raw("count(eva_elegal.sol_id) as cant"))->where([['eva_elegal.verificado','NO'],['eva_asigeva.evaluacion', 'EVALUACION LEGAL']])->whereBetween('eva_asigeva.created_at', [$request->f_ini.' 00:00:00', $request->f_fin.' 23:59:59']);

                    $economica = DB::table('eva_eeconomica')->join('eva_asigeva', 'eva_asigeva.sol_id', '=', 'eva_eeconomica.sol_id')->select(DB::raw('2 as id'),DB::raw("'ECONOMICO-SOCIAL' as eva"),DB::raw("count(eva_eeconomica.sol_id) as cant"))->where([['eva_eeconomica.verificado','NO'],['eva_asigeva.evaluacion', 'EVALUACION ECONOMICO-SOCIAL']])->whereBetween('eva_asigeva.created_at', [$request->f_ini.' 00:00:00', $request->f_fin.' 23:59:59'])->union($legal);

                    $financiera = DB::table('eva_efinanciera')->join('eva_asigeva', 'eva_asigeva.sol_id', '=', 'eva_efinanciera.sol_id')->select(DB::raw('3 as id'),DB::raw("'FINANCIERA' as eva"),DB::raw("count(eva_efinanciera.sol_id) as cant"))->where([['eva_efinanciera.verificado','NO'],['eva_asigeva.evaluacion', 'EVALUACION FINANCIERA']])->whereBetween('eva_asigeva.created_at', [$request->f_ini.' 00:00:00', $request->f_fin.' 23:59:59'])->union($economica);

                    $ingenieria = DB::table('eva_eingdiseno')->join('eva_asigeva', 'eva_asigeva.sol_id', '=', 'eva_eingdiseno.sol_id')->select(DB::raw('4 as id'),DB::raw("'INGENIERIA DE DISEÑO' as eva"),DB::raw("count(eva_eingdiseno.sol_id) as cant"))->where([['eva_eingdiseno.verificado','NO'],['eva_asigeva.evaluacion', 'EVALUACION DE INGENIERIA DE DISEÑO']])->whereBetween('eva_asigeva.created_at', [$request->f_ini.' 00:00:00', $request->f_fin.' 23:59:59'])->union($financiera)->orderBy('id', 'asc');

                $datatable = Datatables::of($ingenieria);
                return $datatable->make(true);

            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
    }

    public function getReporteEvaluacionEnModuloCA(Request $request)
    {
        try{
            if ($request->ajax()) {
                $ingenieria = '';


                    $legal = DB::table('eva_elegal')->join('eva_asigeva', 'eva_asigeva.sol_id', '=', 'eva_elegal.sol_id')->select(DB::raw('1 as id'),DB::raw("'LEGAL' as eva"),DB::raw("count(eva_elegal.sol_id) as cant"))->where([['eva_elegal.verificado','SI'],['eva_asigeva.evaluacion', 'EVALUACION LEGAL']])->whereBetween('eva_asigeva.created_at', [$request->f_ini.' 00:00:00', $request->f_fin.' 23:59:59']);

                    $economica = DB::table('eva_eeconomica')->join('eva_asigeva', 'eva_asigeva.sol_id', '=', 'eva_eeconomica.sol_id')->select(DB::raw('2 as id'),DB::raw("'ECONOMICO-SOCIAL' as eva"),DB::raw("count(eva_eeconomica.sol_id) as cant"))->where([['eva_eeconomica.verificado','SI'],['eva_asigeva.evaluacion', 'EVALUACION ECONOMICO-SOCIAL']])->whereBetween('eva_asigeva.created_at', [$request->f_ini.' 00:00:00', $request->f_fin.' 23:59:59'])->union($legal);

                    $financiera = DB::table('eva_efinanciera')->join('eva_asigeva', 'eva_asigeva.sol_id', '=', 'eva_efinanciera.sol_id')->select(DB::raw('3 as id'),DB::raw("'FINANCIERA' as eva"),DB::raw("count(eva_efinanciera.sol_id) as cant"))->where([['eva_efinanciera.verificado','SI'],['eva_asigeva.evaluacion', 'EVALUACION FINANCIERA']])->whereBetween('eva_asigeva.created_at', [$request->f_ini.' 00:00:00', $request->f_fin.' 23:59:59'])->union($economica);

                    $ingenieria = DB::table('eva_eingdiseno')->join('eva_asigeva', 'eva_asigeva.sol_id', '=', 'eva_eingdiseno.sol_id')->select(DB::raw('4 as id'),DB::raw("'INGENIERIA DE DISEÑO' as eva"),DB::raw("count(eva_eingdiseno.sol_id) as cant"))->where([['eva_eingdiseno.verificado','SI'],['eva_asigeva.evaluacion', 'EVALUACION DE INGENIERIA DE DISEÑO']])->whereBetween('eva_asigeva.created_at', [$request->f_ini.' 00:00:00', $request->f_fin.' 23:59:59'])->union($financiera)->orderBy('id', 'asc');



                $datatable = Datatables::of($ingenieria);
                return $datatable->make(true);

            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
    }

    public function getReporteTiempoFaseLegal(Request $request)
    {
        try{
            if ($request->ajax()) {
                $tiempo = ($request->ver == 'SI') ? "(select age(eva_elegal.updated_at,eva_asigeva.created_at) from eva_elegal where eva_elegal.sol_id = solicitudes.id ) as t_fase": "(select age(now(),eva_asigeva.created_at) from eva_elegal where eva_elegal.sol_id = solicitudes.id ) as t_fase" ;

                $legal = DB::table('solicitudes')
                    ->join('empresas', "solicitudes.emp_rif", '=', "empresas.rif")
                    ->join('eva_asigeva', "eva_asigeva.sol_id", '=', "solicitudes.id")
                    ->join('eva_responsables', "eva_asigeva.resp_id", '=', "eva_responsables.id")
                    ->select(
                        "solicitudes.id",
                        DB::raw("to_char(solicitudes.fecha, 'DD/MM/YYYY') as fecha"),
                        "empresas.empresa",
                        "solicitudes.obj_proyecto",
                        "eva_responsables.nombre",
                        DB::raw($tiempo)
                    )
                    ->whereRaw("(solicitudes.objeto = 'PRESENTACIÓN DE PROYECTO' and eva_asigeva.evaluacion = 'EVALUACION LEGAL')")
                    ->whereRaw("(select eva_elegal.verificado from eva_elegal where eva_elegal.sol_id = solicitudes.id) = '".$request->ver."'")
                    ->whereBetween('eva_asigeva.created_at', [$request->f_ini.' 00:00:00', $request->f_fin.' 23:59:59']);


                $datatable = Datatables::of($legal)
                    ->editColumn('obj_proyecto', function ($mp) {
                        return wordwrap(str_replace('&nbsp;', ' ', $mp->obj_proyecto), 70, '<br>');
                    })
                    ->rawColumns(['obj_proyecto']);;
                return $datatable->make(true);

            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
    }

    public function getReporteTiempoFaseEconomica(Request $request)
    {
        try{
            if ($request->ajax()) {
                $tiempo = ($request->ver == 'SI') ? "(select age(eva_eeconomica.updated_at,eva_elegal.updated_at) from eva_eeconomica, eva_elegal where eva_elegal.sol_id=eva_eeconomica.sol_id and eva_eeconomica.sol_id = solicitudes.id ) as t_fase": "(select age(now(),eva_elegal.updated_at) from eva_eeconomica, eva_elegal where eva_elegal.sol_id=eva_eeconomica.sol_id and eva_eeconomica.sol_id = solicitudes.id ) as t_fase" ;

                $legal = DB::table('solicitudes')
                    ->join('empresas', "solicitudes.emp_rif", '=', "empresas.rif")
                    ->join('eva_asigeva', "eva_asigeva.sol_id", '=', "solicitudes.id")
                    ->join('eva_responsables', "eva_asigeva.resp_id", '=', "eva_responsables.id")
                    ->select(
                        "solicitudes.id",
                        DB::raw("to_char(solicitudes.fecha, 'DD/MM/YYYY') as fecha"),
                        "empresas.empresa",
                        "solicitudes.obj_proyecto",
                        "eva_responsables.nombre",
                        DB::raw($tiempo)
                    )
                    ->whereRaw("(solicitudes.objeto = 'PRESENTACIÓN DE PROYECTO' and eva_asigeva.evaluacion = 'EVALUACION ECONOMICO-SOCIAL')")
                    ->whereRaw("(select eva_eeconomica.verificado from eva_eeconomica where eva_eeconomica.sol_id = solicitudes.id) = '".$request->ver."'")
                    ->whereBetween('eva_asigeva.created_at', [$request->f_ini.' 00:00:00', $request->f_fin.' 23:59:59']);


                $datatable = Datatables::of($legal)
                    ->editColumn('obj_proyecto', function ($mp) {
                        return wordwrap(str_replace('&nbsp;', ' ', $mp->obj_proyecto), 70, '<br>');
                    })
                    ->rawColumns(['obj_proyecto']);;
                return $datatable->make(true);

            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
    }

    public function getReporteTiempoFaseFinanciera(Request $request)
    {
        try{
            if ($request->ajax()) {
                $tiempo = ($request->ver == 'SI') ? "(select age(eva_efinanciera.updated_at,eva_eeconomica.updated_at) from eva_efinanciera, eva_eeconomica where eva_eeconomica.sol_id=eva_efinanciera.sol_id and eva_efinanciera.sol_id = solicitudes.id ) as t_fase": "(select age(now(),eva_eeconomica.updated_at) from eva_efinanciera, eva_eeconomica where eva_eeconomica.sol_id=eva_efinanciera.sol_id and eva_efinanciera.sol_id = solicitudes.id ) as t_fase" ;

                $legal = DB::table('solicitudes')
                    ->join('empresas', "solicitudes.emp_rif", '=', "empresas.rif")
                    ->join('eva_asigeva', "eva_asigeva.sol_id", '=', "solicitudes.id")
                    ->join('eva_responsables', "eva_asigeva.resp_id", '=', "eva_responsables.id")
                    ->select(
                        "solicitudes.id",
                        DB::raw("to_char(solicitudes.fecha, 'DD/MM/YYYY') as fecha"),
                        "empresas.empresa",
                        "solicitudes.obj_proyecto",
                        "eva_responsables.nombre",
                        DB::raw($tiempo)
                    )
                    ->whereRaw("(solicitudes.objeto = 'PRESENTACIÓN DE PROYECTO' and eva_asigeva.evaluacion = 'EVALUACION FINANCIERA')")
                    ->whereRaw("(select eva_efinanciera.verificado from eva_efinanciera where eva_efinanciera.sol_id = solicitudes.id) = '".$request->ver."'")
                    ->whereBetween('eva_asigeva.created_at', [$request->f_ini.' 00:00:00', $request->f_fin.' 23:59:59']);


                $datatable = Datatables::of($legal)
                    ->editColumn('obj_proyecto', function ($mp) {
                        return wordwrap(str_replace('&nbsp;', ' ', $mp->obj_proyecto), 70, '<br>');
                    })
                    ->rawColumns(['obj_proyecto']);;
                return $datatable->make(true);

            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
    }

    public function getReporteTiempoFaseIngenieria(Request $request)
    {
        try{
            if ($request->ajax()) {
                $tiempo = ($request->ver == 'SI') ? "(select age(eva_eingdiseno.updated_at,eva_efinanciera.updated_at) from eva_eingdiseno, eva_efinanciera where eva_efinanciera.sol_id=eva_eingdiseno.sol_id and eva_eingdiseno.sol_id = solicitudes.id ) as t_fase": "(select age(now(),eva_efinanciera.updated_at) from eva_eingdiseno, eva_efinanciera where eva_efinanciera.sol_id=eva_eingdiseno.sol_id and eva_eingdiseno.sol_id = solicitudes.id ) as t_fase" ;

                $legal = DB::table('solicitudes')
                    ->join('empresas', "solicitudes.emp_rif", '=', "empresas.rif")
                    ->join('eva_asigeva', "eva_asigeva.sol_id", '=', "solicitudes.id")
                    ->join('eva_responsables', "eva_asigeva.resp_id", '=', "eva_responsables.id")
                    ->select(
                        "solicitudes.id",
                        DB::raw("to_char(solicitudes.fecha, 'DD/MM/YYYY') as fecha"),
                        "empresas.empresa",
                        "solicitudes.obj_proyecto",
                        "eva_responsables.nombre",
                        DB::raw($tiempo)
                    )
                    ->whereRaw("(solicitudes.objeto = 'PRESENTACIÓN DE PROYECTO' and eva_asigeva.evaluacion = 'EVALUACION DE INGENIERIA DE DISEÑO')")
                    ->whereRaw("(select eva_eingdiseno.verificado from eva_eingdiseno where eva_eingdiseno.sol_id = solicitudes.id) = '".$request->ver."'")
                    ->whereBetween('eva_asigeva.created_at', [$request->f_ini.' 00:00:00', $request->f_fin.' 23:59:59']);


                $datatable = Datatables::of($legal)
                    ->editColumn('obj_proyecto', function ($mp) {
                        return wordwrap(str_replace('&nbsp;', ' ', $mp->obj_proyecto), 70, '<br>');
                    })
                    ->rawColumns(['obj_proyecto']);;
                return $datatable->make(true);

            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
    }



}
