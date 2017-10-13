<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Accion;
use App\Solicitud;
use App\Seguimiento;

class AccionesController extends Controller
{
    //
    public function getIndex()
    {
        return view('sistema.acciones.acciones');
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
                DB::raw("(select count(*) from acciones where acciones.id_sol = solicitudes.id) as acciones"));
        if(Auth::user()->rol == 30){
            $mprima->where('solicitudes.emp_rif', 'ilike', Auth::user()->empresa);
        }

        if(Auth::user()->rol == 2){
            $mprima->where('empresas.usuario', '=', Auth::user()->id);
        }

        $datatable = Datatables::of($mprima)
            ->addColumn('accion', function ($mp) {
                $btn ='';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 1 ||  Auth::user()->rol == 4 || Auth::user()->rol == 2 ){
                    $btn .= '<a href="javascript:void(0);" onclick="addAccion('.$mp->id.')" title="Agregar accion"><i class="fa fa-plus-square fa-lg fa-border"></i></a> ';

                }
                $btn .= '<a href="javascript:void(0);" onclick="verAccion('.$mp->id.')" title="Ver accion(es)"><i class="fa fa-eye fa-lg fa-border"></i><sup class="badge style-info">'.$mp->acciones.'</sup></a> ';


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
            $solicitud = Solicitud::where('id', $request->id)->get();
            $accion = Accion::where('id_sol', $request->id)->orderBy('ra_nivel', 'desc')->first();


            $returnHTML = view('sistema.acciones.form', compact('solicitud','accion'))->render();
            return $returnHTML;
        }
    }

    public function agregarAcciones(Request $request)
    {
        try{
            $mprima = new Accion();

            $mprima->remitido_a =mb_strtoupper((empty($request->remitido_a))? '' : (is_array($request->remitido_a))? implode(',',$request->remitido_a) : $request->remitido_a);
            $mprima->ra_especifique =mb_strtoupper($request->ra_especifique);
            $mprima->ra_forma =mb_strtoupper($request->ra_forma);
            $mprima->raf_especifique =mb_strtoupper($request->raf_especifique);
            $mprima->observacion =mb_strtoupper($request->observacion);
            $mprima->fecha =mb_strtoupper($request->fecha);
            $mprima->ra_nivel =mb_strtoupper($request->ra_nivel);
            $mprima->id_sol =mb_strtoupper($request->id_sol);

           // $mprima->ot_especifique =mb_strtoupper(((empty($request->ot_especifique ))? '' : $request->ot_especifique ) );

            if($mprima->save()){
                UtilidadesController::setLog(Auth::user()->user, 'ACCIONES', 'AGREGAR - '.$request->id_sol.', '.$request->ra_nivel);
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

    public function verAcciones(Request $request)
    {
        if($request->ajax()) {
            $id_sol = $request->id;
            $accion = Accion::where('id_sol', $request->id)->orderBy('ra_nivel', 'asc')->get();


            $returnHTML = view('sistema.acciones.ver', compact('accion','id_sol'))->render();
            return $returnHTML;
        }
    }

    public function eliminarAcciones(Request $request)
    {
        try{
            if($request->ajax()) {
                $count = Seguimiento::where('id_sol', $request->id_sol)->count();

                if($count == 0){
                    $deletedRows = Accion::where('id', $request->id )->delete();
                    if ($deletedRows == 1) {
                        UtilidadesController::setLog(Auth::user()->user, 'ACCIONES', 'ELIMINAR - '.$request->id);
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
                        'msg' => 'No se pudo eliminar el registro<br>Hay actividades de seguimiento que tienen relación con la solicitud',
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
