<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Seguimiento;
use App\Solicitud;
use App\Accion;

class SeguimientoController extends Controller
{
    //
    public function getIndex()
    {
        return view('sistema.seguimiento.seguimiento');
    }

    public function getData(Request $request)
    {
        $mprima = DB::table('solicitudes')
            ->join('empresas', 'solicitudes.emp_rif', '=', 'empresas.rif')
            ->select('solicitudes.id',
                DB::raw("to_char(solicitudes.fecha, 'DD/MM/YYYY') as fecha"),
                'empresas.empresa',
                'solicitudes.origen',
                'solicitudes.ori_especifique',
                'solicitudes.objeto',
                'solicitudes.obj_proyecto',
                'solicitudes.fin_montobs',
                'solicitudes.fin_montousd',
                'solicitudes.fin_para',
                'solicitudes.sol_otros',
                'solicitudes.emp_rif',
                DB::raw("(select count(*) from seguimiento where seguimiento.id_sol = solicitudes.id) as acciones"));
        if(Auth::user()->rol == 30){
            $mprima->where('solicitudes.emp_rif', 'ilike', Auth::user()->empresa);
        }

        if(Auth::user()->rol == 2){
            $mprima->where('empresas.usuario', '=', Auth::user()->id);
        }

        $datatable =  Datatables::of($mprima)
            ->addColumn('accion', function ($mp) {
                $btn = '';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 2 || Auth::user()->rol == 4 || Auth::user()->rol == 1 ){
                    $btn = '<a href="javascript:void(0);" onclick="addSeg('.$mp->id.')" title="Agregar seguimiento"><i class="fa fa-plus-square fa-lg fa-border"></i></a> ';
                }

                $btn .= '<a href="javascript:void(0);" onclick="verSeg('.$mp->id.')" title="Ver aseguimiento"><i class="fa fa-eye fa-lg fa-border"></i><sup class="badge style-info">'.$mp->acciones.'</sup></a> ';


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

    public function verForm(Request $request)
    {
        if($request->ajax()) {
            $count = Accion::where('id_sol', $request->id)->count();
            if($count > 0){
                $st = DB::select( DB::raw("select seguimiento.status from seguimiento where seguimiento.id_sol = ".$request->id."  and seguimiento.id = (select max(seguimiento.id) from seguimiento where seguimiento.id_sol = ".$request->id.")"));
                $status = (isset($st[0]->status))?$st[0]->status: '';
                $solicitud = Solicitud::where('id', $request->id)->get();
                $returnHTML = view('sistema.seguimiento.form', compact('solicitud','status'))->render();
                return $returnHTML;
            }
            else{
                return '<h3 class="text-center">¡¡¡No existen acciones a las cuales hacerle seguimiento para esta solicitud!!!</h3>';
            }

        }
    }

    public function agregarSeguimiento(Request $request)
    {
        try{
            $mprima = new Seguimiento();

            //$mprima->remitido_a =mb_strtoupper((empty($request->remitido_a))? '' : (is_array($request->remitido_a))? implode(',',$request->remitido_a) : $request->remitido_a);
            $mprima->status =mb_strtoupper($request->status);
            $mprima->descripcion =mb_strtoupper($request->descripcion);
            $mprima->fecha =mb_strtoupper($request->fecha);
            $mprima->id_sol =mb_strtoupper($request->id_sol);

            if($mprima->save()){
                UtilidadesController::setLog(Auth::user()->user, 'SEGUIMIENTO', 'AGREGAR - '.$request->id_sol.','.$request->status);
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

    public function verSeguimiento(Request $request)
    {
        if($request->ajax()) {
            $id_sol = $request->id;
            $accion = Accion::where('id_sol', $request->id)->orderBy('ra_nivel', 'asc')->get();
            $seg = Seguimiento::where('id_sol', $request->id)->orderBy('id', 'asc')->orderBy('fecha', 'asc')->get();

            $returnHTML = view('sistema.seguimiento.ver', compact('id_sol','accion','seg'))->render();
            return $returnHTML;
        }
    }

    public function eliminarSeguimiento(Request $request)
    {
        try{
            if($request->ajax()) {

                $deletedRows = Seguimiento::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'SEGUIMIENTO', 'ELIMINAR - '.$request->id);
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
}
