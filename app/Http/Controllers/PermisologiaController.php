<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Permisologia;

class PermisologiaController extends Controller
{
    //
    public function getIndex()
    {
        return view('sistema.solicitudes.permisologia');
    }

    public function getData(Request $request)
    {
        $mprima = DB::table('permisologia')
            ->join('solicitudes', 'permisologia.sol_id', '=', 'solicitudes.id')
            ->join('empresas', 'solicitudes.emp_rif', '=', 'empresas.rif')
            ->select('permisologia.id',
               'empresas.empresa',
                DB::raw("concat(solicitudes.id,' - ',to_char(solicitudes.fecha, 'DD/MM/YYYY'),' ',solicitudes.objeto) as solicitud"),
               'permisologia.institucion',
               'permisologia.descripcion');
        if(Auth::user()->rol == 30){
            $mprima->where('solicitudes.emp_rif', 'ilike', Auth::user()->empresa);
        }

        if(Auth::user()->rol == 2){
            $mprima->where('empresas.usuario', '=', Auth::user()->id);
        }

        $datatable = Datatables::of($mprima)
            ->addColumn('accion', function ($mp) {
                $btn = '';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 2 || Auth::user()->rol == 4 || Auth::user()->rol == 30){
                    $btn .= '<a href="javascript:void(0);" onclick="findUpdateEnc('.$mp->id.')"><i class="fa fa-edit fa-lg fa-border"></i></a> ';
                    if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                        $btn .= '<a href="javascript:void(0);" onclick="deleteEnc('.$mp->id.')"><i class="fa fa-trash-o fa-lg fa-border style-danger"></i></a>';
                    }
                }

                //$btn .='<a href="javascript:void(0);" onclick="viewEnc('.$mp->id.')"><i class="fa fa-eye fa-lg fa-border"></i></a>';

                return $btn;
            })
            ->rawColumns(['accion']);

        if ($keyword = $request->get('search')['value']) {
            // override users.id global search - demo for concat
            $datatable->filterColumn('solicitud', 'whereRaw', "concat(solicitudes.id,' - ',to_char(solicitudes.fecha, 'DD/MM/YYYY'),' ',solicitudes.objeto) ilike ? ", ["%$keyword%"]);
        }
           return $datatable->make(true);

    }


    public function agregarPermisologia(Request $request)
    {

        try{
            $mprima = new Permisologia();

            $mprima->institucion =mb_strtoupper($request->institucion  );
            $mprima->ot_especifique =mb_strtoupper(((empty($request->ot_especifique ))? '' : $request->ot_especifique ) );
            $mprima->descripcion =mb_strtoupper($request->descripcion  );
            $mprima->sol_id =mb_strtoupper($request->id_sol  );


            /*
            $mprima->obstaculos =mb_strtoupper((empty($request->obstaculos))? '' : implode(',',$request->obstaculos));*/

            if($mprima->save()){
                UtilidadesController::setLog(Auth::user()->user, 'PERMISOLOGIA', 'AGREGAR');
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

    public function buscarPermisologia(Request $request)
    {
        if($request->ajax()) {
            $mprima = DB::table('permisologia')
                ->join('solicitudes', 'permisologia.sol_id', '=', 'solicitudes.id')
                ->join('empresas', 'solicitudes.emp_rif', '=', 'empresas.rif')
                ->select('permisologia.id',
                    'solicitudes.id as id_sol',
                    DB::raw("concat(solicitudes.id,' - ',to_char(solicitudes.fecha, 'DD/MM/YYYY'),' ',solicitudes.objeto) as solicitud"),
                    'permisologia.institucion',
                    'permisologia.ot_especifique',
                    'permisologia.descripcion')
                ->where('permisologia.id', '=', $request->id)->get();
            return response()->json($mprima);
        }
    }

    public function actualizarPermisologia(Request $request)
    {
        try{
            $mprima = Permisologia::find($request->id);

            $mprima->institucion =mb_strtoupper($request->institucion  );
            $mprima->ot_especifique =mb_strtoupper(((empty($request->ot_especifique ))? '' : $request->ot_especifique ) );
            $mprima->descripcion =mb_strtoupper($request->descripcion  );
            $mprima->sol_id =mb_strtoupper($request->id_sol  );


            if($mprima->update()){
                UtilidadesController::setLog(Auth::user()->user, 'PERMISOLOGIA', 'ACTUALIZAR');
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

    public function eliminarPermisologia(Request $request)
    {
        try{
            if($request->ajax()) {

                $deletedRows = Permisologia::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'PERMISOLOGIA', 'ELIMINAR');
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
