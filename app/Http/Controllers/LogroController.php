<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Logro;

class LogroController extends Controller
{
    //
    public function getIndex()
    {
        return view('sistema.logros.logros');
    }

    public function getData(Request $request)
    {
        $mprima = DB::table('logros')
            ->join('encuestas', 'logros.rif_enc', '=', 'encuestas.rif')
            ->select('logros.id',
                'encuestas.empresa',
                DB::raw("to_char(logros.fecha, 'DD/MM/YYYY') as fecha"),
                'logros.logro');

        return Datatables::of($mprima)
            ->addColumn('accion', function ($mp) {
                $btn = '<a href="javascript:void(0);" onclick="findUpdateEnc('.$mp->id.')"><i class="fa fa-edit fa-lg fa-border"></i></a> ';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                 $btn .= '<a href="javascript:void(0);" onclick="deleteEnc('.$mp->id.')"><i class="fa fa-trash-o fa-lg fa-border style-danger"></i></a>';
                }
                return $btn;

            })

            ->filterColumn('fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })
            ->rawColumns(['accion'])
            ->make(true);

    }

    public function agregarLogro(Request $request)
    {

        try{
            $mprima = new Logro();

            $mprima->fecha     =mb_strtoupper($request->fecha );
            $mprima->logro      =mb_strtoupper($request->logro );
            $mprima->rif_enc      =mb_strtoupper($request->rif_enc);

            /*
            $mprima->obstaculos =mb_strtoupper((empty($request->obstaculos))? '' : implode(',',$request->obstaculos));*/

            if($mprima->save()){
                UtilidadesController::setLog(Auth::user()->user, 'LOGROS', 'AGREGAR');
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

    public function buscarLogro(Request $request)
    {
        if($request->ajax()) {
            $mprima = DB::table('logros')
                ->join('encuestas', 'logros.rif_enc', '=', 'encuestas.rif')
                ->select('logros.id',
                    'encuestas.empresa',
                    'logros.fecha',
                    'logros.logro',
                    'logros.rif_enc')
                ->where('logros.id', '=', $request->id)->get();
            return response()->json($mprima);
        }
    }

    public function actualizarLogro(Request $request)
    {
        try{
            $mprima = Logro::find($request->id);
            $mprima->fecha     =mb_strtoupper($request->fecha );
            $mprima->logro      =mb_strtoupper($request->logro );
            $mprima->rif_enc      =mb_strtoupper($request->rif_enc);


            if($mprima->update()){
                UtilidadesController::setLog(Auth::user()->user, 'LOGROS', 'ACTUALIZAR');
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

    public function eliminarLogro(Request $request)
    {
        try{
            if($request->ajax()) {

                $deletedRows = Logro::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'LOGROS', 'ELIMINAR');
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
