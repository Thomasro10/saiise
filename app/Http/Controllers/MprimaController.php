<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Mprima;

class MprimaController extends Controller
{
    //
    public function getIndex()
    {
         $no_cache = rand();
         return view('sistema.solicitudes.mprima',compact('no_cache'));
    }

    public function getData(Request $request)
    {
        $mprima = DB::table('mprima')
            ->join('solicitudes', 'mprima.id_sol', '=', 'solicitudes.id')
            ->join('empresas', 'solicitudes.emp_rif', '=', 'empresas.rif')
            ->select('mprima.id',
                'empresas.empresa',
                DB::raw("concat(solicitudes.id,' - ',to_char(solicitudes.fecha, 'DD/MM/YYYY'),' ',solicitudes.objeto) as solicitud"),
                'mprima.tipo',
                'mprima.descripcion',
                'mprima.cantidad',
                'mprima.medida');
        if(Auth::user()->rol == 30){
            $mprima->where('solicitudes.emp_rif', 'ilike', Auth::user()->empresa);
        }

        if(Auth::user()->rol == 2){
            $mprima->where('empresas.usuario', '=', Auth::user()->id);
        }

        $datatable = Datatables::of($mprima)
            ->addColumn('accion', function ($mp) {
                $btn = '';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 2 || Auth::user()->rol == 4 || Auth::user()->rol == 1 || Auth::user()->rol == 30){
                    $btn .= '<a href="javascript:void(0);" onclick="findUpdateEnc('.$mp->id.')"><i class="fa fa-edit fa-lg fa-border"></i></a> ';
                    if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                        $btn .= '<a href="javascript:void(0);" onclick="deleteEnc('.$mp->id.')"><i class="fa fa-trash-o fa-lg fa-border style-danger"></i></a>';
                    }
                }
                return $btn;
            })
            ->rawColumns(['accion']);
        if ($keyword = $request->get('search')['value']) {
            // override users.id global search - demo for concat
            $datatable->filterColumn('solicitud', 'whereRaw', "concat(solicitudes.id,' - ',to_char(solicitudes.fecha, 'DD/MM/YYYY'),' ',solicitudes.objeto) ilike ? ", ["%$keyword%"]);
        }
        return    $datatable->make(true);

    }

    public function agregarMprima(Request $request)
    {
        try{
            $mprima = new Mprima();

            $mprima->tipo     =mb_strtoupper($request->tipo);
            $mprima->descripcion      =mb_strtoupper($request->descripcion);
            $mprima->cantidad      =mb_strtoupper($request->cantidad);
            $mprima->medida      =mb_strtoupper($request->medida);
            $mprima->id_sol      =mb_strtoupper($request->id_sol);

            /*
            $mprima->obstaculos =mb_strtoupper((empty($request->obstaculos))? '' : implode(',',$request->obstaculos));*/

            if($mprima->save()){
                UtilidadesController::setLog(Auth::user()->user, 'MATERIA PRIMA', 'AGREGAR');
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

    public function buscarMprima(Request $request)
    {
        if($request->ajax()) {
            $mprima = DB::table('mprima')
                ->join('solicitudes', 'mprima.id_sol', '=', 'solicitudes.id')
                ->join('empresas', 'solicitudes.emp_rif', '=', 'empresas.rif')
                ->select('mprima.id',
                    'empresas.empresa',
                    'solicitudes.id as id_sol',
                    DB::raw("concat(solicitudes.id,' - ',to_char(solicitudes.fecha, 'DD/MM/YYYY'),' ',solicitudes.objeto) as solicitud"),
                    'mprima.tipo',
                    'mprima.descripcion',
                    'mprima.cantidad',
                    'mprima.medida')
                ->where('mprima.id', '=', $request->id)->get();
            return response()->json($mprima);
        }
    }

    public function actualizarMprima(Request $request)
    {
        try{
            $mprima = Mprima::find($request->id);
            $mprima->tipo     =mb_strtoupper($request->tipo);
            $mprima->descripcion      =mb_strtoupper($request->descripcion);
            $mprima->cantidad      =mb_strtoupper($request->cantidad);
            $mprima->medida      =mb_strtoupper($request->medida);
            $mprima->id_sol      =mb_strtoupper($request->id_sol);


            if($mprima->update()){
                UtilidadesController::setLog(Auth::user()->user, 'MATERIA PRIMA', 'ACTUALIZAR');
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

    public function eliminarMprima(Request $request)
    {
        try{
            if($request->ajax()) {

                $deletedRows = Mprima::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'MATERIA PRIMA', 'ELIMINAR');
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
