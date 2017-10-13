<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Rqfinanciamiento;

class RqfinanciamientoController extends Controller
{
    //
    public function getIndex()
    {
        return view('sistema.finanzas.finanzas');
    }

    public function getData(Request $request)
    {
        $mprima = DB::table('rqfinanciamiento')
            ->join('empresas', 'rqfinanciamiento.rif_emp', '=', 'empresas.rif')
            ->select('rqfinanciamiento.id',
                'empresas.empresa',
                'rqfinanciamiento.divpropias',
                'rqfinanciamiento.dppropuesta',
                'rqfinanciamiento.exportar',
                'rqfinanciamiento.expropuesta',
                'rqfinanciamiento.rfinancieros',
                'rqfinanciamiento.montobs',
                'rqfinanciamiento.montodiv',
                'rqfinanciamiento.observacion',
                'rqfinanciamiento.rif_emp');
        if(Auth::user()->rol == 30){
            $mprima->where('rqfinanciamiento.rif_emp', 'ilike', Auth::user()->empresa);
        }

        return Datatables::of($mprima)
            ->addColumn('accion', function ($mp) {
                $btn = '';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 2 || Auth::user()->rol == 30){
                    $btn .= '<a href="javascript:void(0);" onclick="findUpdateEnc('.$mp->id.')"><i class="fa fa-edit fa-lg fa-border"></i></a>';
                    if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                        $btn .='<a href="javascript:void(0);" onclick="deleteEnc('.$mp->id.')"><i class="fa fa-trash-o fa-lg fa-border style-danger"></i></a>';
                    }
                }

                return  $btn;

            })
            ->rawColumns(['accion'])
            ->make(true);

    }

    public function agregarRqfinanciamiento(Request $request)
    {
        try{
            $mprima = new Rqfinanciamiento();

            $mprima->divpropias     =mb_strtoupper($request->divpropias );
            $mprima->dppropuesta     =mb_strtoupper($request->dppropuesta );
            $mprima->exportar     =mb_strtoupper($request->exportar);
            $mprima->expropuesta    =mb_strtoupper($request->expropuesta );
            $mprima->rfinancieros      =mb_strtoupper($request->rfinancieros );
            $mprima->montobs      =mb_strtoupper($request->montobs);
            $mprima->montodiv     =mb_strtoupper($request->montodiv);
            $mprima->observacion      =mb_strtoupper($request->observacion );
            $mprima->rif_emp      =mb_strtoupper($request->rif_emp);

            /*
            $mprima->obstaculos =mb_strtoupper((empty($request->obstaculos))? '' : implode(',',$request->obstaculos));*/

            if($mprima->save()){
                UtilidadesController::setLog(Auth::user()->user, 'REQ FINANCIAMIENTO', 'AGREGAR');
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

    public function buscarRqfinanciamiento(Request $request)
    {
        if($request->ajax()) {
            $mprima = DB::table('rqfinanciamiento')
                ->join('empresas', 'rqfinanciamiento.rif_emp', '=', 'empresas.rif')
                ->select('rqfinanciamiento.id',
                    'empresas.empresa',
                    'rqfinanciamiento.divpropias',
                    'rqfinanciamiento.dppropuesta',
                    'rqfinanciamiento.exportar',
                    'rqfinanciamiento.expropuesta',
                    'rqfinanciamiento.rfinancieros',
                    'rqfinanciamiento.montobs',
                    'rqfinanciamiento.montodiv',
                    'rqfinanciamiento.observacion',
                    'rqfinanciamiento.rif_emp')
                ->where('rqfinanciamiento.id', '=', $request->id)->get();
            return response()->json($mprima);
        }
    }

    public function actualizarRqfinanciamiento(Request $request)
    {
        try{
            $mprima = Rqfinanciamiento::find($request->id);
            $mprima->divpropias     =mb_strtoupper($request->divpropias );
            $mprima->dppropuesta     =mb_strtoupper($request->dppropuesta );
            $mprima->exportar     =mb_strtoupper($request->exportar);
            $mprima->expropuesta    =mb_strtoupper($request->expropuesta );
            $mprima->rfinancieros      =mb_strtoupper($request->rfinancieros );
            $mprima->montobs      =mb_strtoupper($request->montobs);
            $mprima->montodiv     =mb_strtoupper($request->montodiv);
            $mprima->observacion      =mb_strtoupper($request->observacion );
            $mprima->rif_emp      =mb_strtoupper($request->rif_emp);


            if($mprima->update()){
                UtilidadesController::setLog(Auth::user()->user, 'REQ FINANCIAMIENTO', 'ACTUALIZAR');
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

    public function eliminarRqfinanciamiento(Request $request)
    {
        try{
            if($request->ajax()) {

                $deletedRows = Rqfinanciamiento::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'REQ FINANCIAMIENTO', 'ELIMINAR');
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
