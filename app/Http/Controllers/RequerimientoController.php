<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Requerimiento;

class RequerimientoController extends Controller
{
    //
    public function getIndex()
    {
        return view('sistema.requerimientos.requerimientos');
    }

    public function getData(Request $request)
    {
        $mprima = DB::table('requerimientos')
            ->join('empresas', 'requerimientos.rif_emp', '=', 'empresas.rif')
            ->select('requerimientos.id',
                'empresas.empresa',
                'requerimientos.requerimiento',
                'requerimientos.solucion',
                'requerimientos.acuerdo');
        if(Auth::user()->rol == 30){
            $mprima->where('requerimientos.rif_emp', 'ilike', Auth::user()->empresa);
        }

        return Datatables::of($mprima)
            ->addColumn('accion', function ($mp) {
                $btn = '';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 2 || Auth::user()->rol == 30){
                    $btn .= '<a href="javascript:void(0);" onclick="findUpdateEnc('.$mp->id.')"><i class="fa fa-edit fa-lg fa-border"></i></a>';
                    if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                        $btn .= '<a href="javascript:void(0);" onclick="deleteEnc('.$mp->id.')"><i class="fa fa-trash-o fa-lg fa-border style-danger"></i></a>';
                    }
                }

                return $btn;
            })
            ->rawColumns(['accion'])
            ->make(true);

    }

    public function agregarRequerimiento(Request $request)
    {
        try{
            $mprima = new Requerimiento();

            $mprima->requerimiento     =mb_strtoupper($request->requerimiento );
            $mprima->solucion      =mb_strtoupper($request->solucion );
            $mprima->acuerdo      =mb_strtoupper($request->acuerdo );
            $mprima->rif_emp      =mb_strtoupper($request->rif_emp);

            /*
            $mprima->obstaculos =mb_strtoupper((empty($request->obstaculos))? '' : implode(',',$request->obstaculos));*/

            if($mprima->save()){
                UtilidadesController::setLog(Auth::user()->user, 'REQUERIMIENTOS', 'AGREGAR');
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

    public function buscarRequerimiento(Request $request)
    {
        if($request->ajax()) {
            $mprima = DB::table('requerimientos')
                ->join('empresas', 'requerimientos.rif_emp', '=', 'empresas.rif')
                ->select('requerimientos.id',
                    'empresas.empresa',
                    'requerimientos.rif_emp',
                    'requerimientos.requerimiento',
                    'requerimientos.solucion',
                    'requerimientos.acuerdo')
                ->where('requerimientos.id', '=', $request->id)->get();
            return response()->json($mprima);
        }
    }

    public function actualizarRequerimiento(Request $request)
    {
        try{
            $mprima = Requerimiento::find($request->id);
            $mprima->requerimiento     =mb_strtoupper($request->requerimiento );
            $mprima->solucion      =mb_strtoupper($request->solucion );
            $mprima->acuerdo      =mb_strtoupper($request->acuerdo );
            $mprima->rif_emp      =mb_strtoupper($request->rif_emp);


            if($mprima->update()){
                UtilidadesController::setLog(Auth::user()->user, 'REQUERIMIENTOS', 'ACTUALIZAR');
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
                    'msg' => $e->getCode().'-'.$e->getMessage()/*UtilidadesController::errorPostgres($e->getCode())*/
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

    public function eliminarRequerimiento(Request $request)
    {
        try{
            if($request->ajax()) {
                $deletedRows = Requerimiento::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'REQUERIMIENTOS', 'ELIMINAR');
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
