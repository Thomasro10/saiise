<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Solicitud;

class SolicitudController extends Controller
{
    //
    public function getIndex()
    {
        return view('sistema.solicitudes.solicitudes');
    }

    public function getData(Request $request)
    {
        //dd($request->all());
        $mprima = DB::table('solicitudes')
            ->join('empresas', 'solicitudes.emp_rif', '=', 'empresas.rif')
            ->select('solicitudes.id',
                DB::raw("to_char(solicitudes.fecha, 'DD/MM/YYYY') as fecha"),
                'empresas.empresa',
                'solicitudes.origen',
                'solicitudes.ori_especifique',
                'solicitudes.objeto',
                'solicitudes.obj_proyecto',
                'solicitudes.tproy',
                'solicitudes.fin_montobs',
                'solicitudes.fin_montousd',
                'solicitudes.fin_banco',
                'solicitudes.fin_para',
                'solicitudes.sol_otros',
                'solicitudes.observacion',
                'solicitudes.emp_rif',
                'solicitudes.status',
                'solicitudes.fecha_status');
        //dd($mprima);
        if(Auth::user()->rol == 30){
            $mprima->where('solicitudes.emp_rif', 'ilike', Auth::user()->empresa);
        }
        if(Auth::user()->rol == 2){
            $mprima->where('empresas.usuario', '=', Auth::user()->id);
        }

        if(Auth::user()->rol == 5){
            $mprima->where('solicitudes.objeto', '=', 'FINANCIAMIENTO');
        }

        if(Auth::user()->rol == 40){
            $mprima->where('solicitudes.objeto', '=', 'PRESENTACIÓN DE PROYECTO');
        }
        /*if ($request->fecha_inicio &&  $request->fecha_fin) {
            $mprima->whereBetween('solicitudes.fecha', [$request->fecha_inicio, $request->fecha_fin]);
        }*/

        //$mprima->toSql();

        $datatable = Datatables::of($mprima)
            ->addColumn('accion', function ($mp) {
                $btn = '';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 2 || Auth::user()->rol == 4 || Auth::user()->rol == 30) {
                    $btn .= '<a href="javascript:void(0);" onclick="findUpdateEnc('.$mp->id.')"><i class="fa fa-edit fa-lg fa-border"></i></a> ';
                    if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                        $btn .= '<a href="javascript:void(0);" onclick="deleteEnc('.$mp->id.')"><i class="fa fa-trash-o fa-lg fa-border style-danger"></i></a>';
                    }
                }

                $btn .='<a href="javascript:void(0);" onclick="viewEnc('.$mp->id.')"><i class="fa fa-eye fa-lg fa-border"></i></a>';

                if($mp->objeto == 'FINANCIAMIENTO'){
                    if(empty($mp->status)){
                        if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 5){
                            $btn .= '<a href="javascript:void(0);" onclick="aprobar('.$mp->id.')" title="APROBAR"><i class="fa fa-check-circle fa-lg fa-border style-info"></i></a>';
                        }
                    }
                    elseif($mp->status == 'APROBADO'){
                        if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                            $btn .= '<a href="javascript:void(0);" onclick="resetAprobar('.$mp->id.')" title="APROBADO '.UtilidadesController::convertirFecha($mp->fecha_status).'"><i class="fa fa-check-circle fa-lg fa-border style-success"></i></a>';
                        }
                        else{
                            $btn .= '<i class="fa fa-check-circle fa-lg fa-border style-success" title="APROBADO '.UtilidadesController::convertirFecha($mp->fecha_status).'"></i>';
                        }
                    }
                    else{
                        if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                            $btn .= '<a href="javascript:void(0);" onclick="resetAprobar('.$mp->id.')" title="NO APROBADO  '.UtilidadesController::convertirFecha($mp->fecha_status).'"><i class="fa fa-times-circle fa-lg fa-border style-danger"></i></a>';
                        }
                        else{
                            $btn .= '<i class="fa fa-times-circle fa-lg fa-border style-danger" title="NO APROBADO  '.UtilidadesController::convertirFecha($mp->fecha_status).'"></i>';
                        }
                    }
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


    public function agregarSolicitud(Request $request)
    {

        try{
            $mprima = new Solicitud();
            $mprima->fecha =mb_strtoupper($request->fecha );
            $mprima->origen =mb_strtoupper($request->origen  );
            $mprima->ori_especifique =mb_strtoupper((empty($request->ori_especifique ))? '' : $request->ori_especifique);
            $mprima->objeto =mb_strtoupper($request->objeto  );
            $mprima->obj_proyecto =mb_strtoupper(((empty($request->obj_proyecto ))? '' : $request->obj_proyecto));
            $mprima->tproy =mb_strtoupper($request->tproy );
            $mprima->fin_montobs =mb_strtoupper(((empty($request->fin_montobs ))? 0 : str_replace(',','.',$request->fin_montobs))  );
            $mprima->fin_montousd =mb_strtoupper(((empty($request->fin_montousd ))? 0 : str_replace(',','.',$request->fin_montousd) ) );
            $mprima->fin_para =mb_strtoupper((empty($request->fin_para ))? '' : implode(',',$request->fin_para ));

            $mprima->fin_banco =mb_strtoupper((empty($request->fin_banco ))? '' : implode(',',$request->fin_banco ));

            $mprima->sol_otros =mb_strtoupper(((empty($request->sol_otros ))? '' : $request->sol_otros)  );
            $mprima->observacion =mb_strtoupper(((empty($request->observacion ))? '' : $request->observacion)  );
            $mprima->emp_rif=mb_strtoupper($request->rif_emp );


            /*
            $mprima->obstaculos =mb_strtoupper((empty($request->obstaculos))? '' : implode(',',$request->obstaculos));*/

            if($mprima->save()){
                UtilidadesController::setLog(Auth::user()->user, 'SOLICITUD', 'AGREGAR - '.mb_strtoupper($request->fecha ).' - '.mb_strtoupper($request->objeto), mb_strtoupper($request->rif_emp ));
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

    public function buscarSolicitud(Request $request)
    {
        if($request->ajax()) {
            $mprima = DB::table('solicitudes')
                ->join('empresas', 'solicitudes.emp_rif', '=', 'empresas.rif')
                ->select('solicitudes.id',
                    'solicitudes.fecha',
                    'empresas.empresa',
                    'solicitudes.origen',
                    'solicitudes.ori_especifique',
                    'solicitudes.objeto',
                    'solicitudes.obj_proyecto',
                    'solicitudes.tproy',
                    'solicitudes.fin_montobs',
                    'solicitudes.fin_montousd',
                    'solicitudes.fin_para',
                    'solicitudes.fin_banco',
                    'solicitudes.sol_otros',
                    'solicitudes.observacion',
                    'solicitudes.emp_rif')
                ->where('solicitudes.id', '=', $request->id)->get();
            return response()->json($mprima);
        }
    }

    public function actualizarSolicitud(Request $request)
    {
        try{
            $mprima = Solicitud::find($request->id);

            $mprima->fecha =mb_strtoupper($request->fecha );
            $mprima->origen =mb_strtoupper($request->origen  );
            $mprima->ori_especifique =mb_strtoupper((empty($request->ori_especifique ))? '' : $request->ori_especifique);
            $mprima->objeto =mb_strtoupper($request->objeto  );
            $mprima->obj_proyecto =mb_strtoupper(((empty($request->obj_proyecto ))? '' : $request->obj_proyecto));
            $mprima->tproy =mb_strtoupper(((empty($request->tproy ))? '' : $request->tproy));

            $mprima->fin_montobs =mb_strtoupper(((empty($request->fin_montobs ))? 0 : str_replace(',','.',$request->fin_montobs) )  );
            $mprima->fin_montousd =mb_strtoupper(((empty($request->fin_montousd ))? 0 : str_replace(',','.',$request->fin_montousd) ) );
            $mprima->fin_para =mb_strtoupper((empty($request->fin_para ))? '' : implode(',',$request->fin_para ));

            $mprima->fin_banco =mb_strtoupper((empty($request->fin_banco ))? '' : implode(',',$request->fin_banco ));

            $mprima->sol_otros =mb_strtoupper(((empty($request->sol_otros ))? '' : $request->sol_otros)  );
            $mprima->observacion =mb_strtoupper(((empty($request->observacion ))? '' : $request->observacion)  );
            $mprima->emp_rif=mb_strtoupper($request->rif_emp );


            if($mprima->update()){
                UtilidadesController::setLog(Auth::user()->user, 'SOLICITUD', 'ACTUALIZAR - '.mb_strtoupper($request->fecha ).' - '.mb_strtoupper($request->objeto), mb_strtoupper($request->rif_emp ));
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

    public function eliminarSolicitud(Request $request)
    {
        try{
            if($request->ajax()) {

                $deletedRows = Solicitud::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'SOLICITUD', 'ELIMINAR - '.$request->id);
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

    public function verSolicitud(Request $request)
    {
        if($request->ajax()) {
            $solicitud = UtilidadesController::getDetalleSolicitud($request->id);
            $permisos = UtilidadesController::getPermisologia($solicitud[0]->id);
            $mprima = UtilidadesController::getMprima($solicitud[0]->id);

            $returnHTML = view('sistema.solicitudes.detalle', compact('solicitud','mprima','permisos'))->render();
            return $returnHTML;
        }
    }


    public function aprobarSolicitud(Request $request)
    {
        try{
            if($request->ajax()) {

                $solicitud = Solicitud::find($request->id);
                $solicitud->status = $request->statusSol;
                $solicitud->fecha_status = date('Y-m-d');
                $solicitud->save();

                    UtilidadesController::setLog(Auth::user()->user, 'SOLICITUD', 'APROBAR - '.$request->id);
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

    public function raprobarSolicitud(Request $request)
    {
        try{
            if($request->ajax()) {

                $solicitud = Solicitud::find($request->id);
                $solicitud->status = null;
                $solicitud->fecha_status = null;
                $solicitud->save();

                UtilidadesController::setLog(Auth::user()->user, 'SOLICITUD', 'RESET APROBAR - '.$request->id);
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

}
