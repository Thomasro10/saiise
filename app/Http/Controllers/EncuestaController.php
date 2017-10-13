<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Encuesta;
use App\Estado;

class EncuestaController extends Controller
{
    //
    public function getIndex()
    {
        $edos = Estado::orderBy('nombre', 'asc')->get();
        return view('sistema.encuestas.encuestas', compact('edos'));
    }

    public function getData(Request $request)
    {


        $encuestas = DB::table('empresas')
            ->join('encuestas', 'encuestas.rif_emp', '=', 'empresas.rif')
            ->select('encuestas.id',
                DB::raw("to_char(fecha, 'DD/MM/YYYY') as fecha"),
                'empresas.empresa',
                'empresas.rif',
                'encuestas.tempresa',
                'encuestas.ntrabajadores',
                'encuestas.acteconomica',
                'encuestas.aeespec',
                'encuestas.capinstalada',
                'encuestas.medida',
                'encuestas.pdc2013',
                'encuestas.pdc2014',
                'encuestas.pdc2015',
                'encuestas.pdc2016',
                'encuestas.pdcactual',
                'encuestas.capoperativa',
                'encuestas.motor',
                'encuestas.motorespc',
                'encuestas.mprima',
                'encuestas.descripcion',
                'encuestas.mercabast',
                'encuestas.rubros',
                'encuestas.obstaculos');
        if(Auth::user()->rol == 30){
            $encuestas->where('encuestas.rif_emp', 'ilike', Auth::user()->empresa);
        }
            //->where('oficina.nombre', 'NOT ILIKE', '%DELETE%');

        return Datatables::of($encuestas)
            ->addColumn('accion', function ($encuestas) {
                $btn = '';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 2 || Auth::user()->rol == 30){
                    $btn .= '<a href="javascript:void(0);" onclick="findUpdateEnc('.$encuestas->id.')"><i class="fa fa-edit fa-lg fa-border"></i></a> ';
                    if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                        $btn .='<a href="javascript:void(0);" onclick="deleteEnc('.$encuestas->id.')"><i class="fa fa-trash-o fa-lg fa-border style-danger"></i></a>';
                    }
                }


                $btn .='<a href="javascript:void(0);" onclick="viewEnc('.$encuestas->id.')"><i class="fa fa-eye fa-lg fa-border"></i></a>';

                return  $btn;
            })
            ->filterColumn('fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })
            ->rawColumns(['accion'])
            ->make(true);

    }

    public function agregarEncuesta(Request $request)
    {
        try{
            $encuestas = new Encuesta();
            $encuestas->fecha   =mb_strtoupper($request->fecha);
            $encuestas->tempresa   =mb_strtoupper($request->tempresa);
            $encuestas->ntrabajadores=mb_strtoupper($request->ntrabajadores);
            $encuestas->acteconomica=mb_strtoupper($request->acteconomica);
            $encuestas->aeespec    =mb_strtoupper($request->aeespec);
            $encuestas->capinstalada=mb_strtoupper($request->capinstalada);
            $encuestas->medida     =mb_strtoupper($request->medida);
            $encuestas->pdc2013    =mb_strtoupper($request->pdc2013);
            $encuestas->pdc2014    =mb_strtoupper($request->pdc2014);
            $encuestas->pdc2015    =mb_strtoupper($request->pdc2015);
            $encuestas->pdc2016    =mb_strtoupper($request->pdc2016);
            $encuestas->pdcactual  =mb_strtoupper($request->pdcactual);
            $encuestas->capoperativa=mb_strtoupper($request->capoperativa);
            $encuestas->motor      =mb_strtoupper($request->motor);
            $encuestas->motorespc  =mb_strtoupper($request->motorespc);
            $encuestas->mprima     =mb_strtoupper($request->mprima);
            $encuestas->descripcion=mb_strtoupper($request->descripcion);
            $encuestas->mercabast  =mb_strtoupper($request->mercabast);
            $encuestas->rubros     =mb_strtoupper($request->rubros);
            $encuestas->obstaculos =mb_strtoupper((empty($request->obstaculos))? '' : implode(',',$request->obstaculos));
            $encuestas->rif_emp    =mb_strtoupper($request->rif_emp);

            if($encuestas->save()){
                UtilidadesController::setLog(Auth::user()->user, 'INF COMPLEMENTARIA', 'AGREGAR - '.mb_strtoupper($request->rif_emp));
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
                    //'msg' => $e->getCode().'-'.$e->getMessage()
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

    public function buscarEncuesta(Request $request)
    {
        if($request->ajax()) {
            $encuestas = DB::table('empresas')
                ->join('encuestas', 'encuestas.rif_emp', '=', 'empresas.rif')
                ->select('encuestas.id',
                    'encuestas.fecha',
                    'empresas.empresa',
                    'empresas.rif',
                    'encuestas.tempresa',
                    'encuestas.ntrabajadores',
                    'encuestas.acteconomica',
                    'encuestas.aeespec',
                    'encuestas.capinstalada',
                    'encuestas.medida',
                    'encuestas.pdc2013',
                    'encuestas.pdc2014',
                    'encuestas.pdc2015',
                    'encuestas.pdc2016',
                    'encuestas.pdcactual',
                    'encuestas.capoperativa',
                    'encuestas.motor',
                    'encuestas.motorespc',
                    'encuestas.mprima',
                    'encuestas.descripcion',
                    'encuestas.mercabast',
                    'encuestas.rubros',
                    'encuestas.obstaculos')
                ->where('encuestas.id', '=', $request->id)->get();
            return response()->json($encuestas);
        }
    }

    public function actualizarEncuesta(Request $request)
    {
        try{
            $encuestas = Encuesta::find($request->id);
            $encuestas->fecha   =mb_strtoupper($request->fecha);
            $encuestas->tempresa   =mb_strtoupper($request->tempresa);
            $encuestas->ntrabajadores=mb_strtoupper($request->ntrabajadores);
            $encuestas->acteconomica=mb_strtoupper($request->acteconomica);
            $encuestas->aeespec    =mb_strtoupper($request->aeespec);
            $encuestas->capinstalada=mb_strtoupper($request->capinstalada);
            $encuestas->medida     =mb_strtoupper($request->medida);
            $encuestas->pdc2013    =mb_strtoupper($request->pdc2013);
            $encuestas->pdc2014    =mb_strtoupper($request->pdc2014);
            $encuestas->pdc2015    =mb_strtoupper($request->pdc2015);
            $encuestas->pdc2016    =mb_strtoupper($request->pdc2016);
            $encuestas->pdcactual  =mb_strtoupper($request->pdcactual);
            $encuestas->capoperativa=mb_strtoupper($request->capoperativa);
            $encuestas->motor      =mb_strtoupper($request->motor);
            $encuestas->motorespc  =mb_strtoupper($request->motorespc);
            $encuestas->mprima     =mb_strtoupper($request->mprima);
            $encuestas->descripcion=mb_strtoupper($request->descripcion);
            $encuestas->mercabast  =mb_strtoupper($request->mercabast);
            $encuestas->rubros     =mb_strtoupper($request->rubros);
            $encuestas->obstaculos =mb_strtoupper((empty($request->obstaculos))? '' : implode(',',$request->obstaculos));
            $encuestas->rif_emp    =mb_strtoupper($request->rif_emp);


            if($encuestas->update()){
                UtilidadesController::setLog(Auth::user()->user, 'ENCUESTAS', 'ACTUALIZAR - '.mb_strtoupper($request->rif_emp));
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

    public function eliminarEncuesta(Request $request)
    {
        if($request->ajax()) {
            try{
                $deletedRows = Encuesta::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'ENCUESTAS', 'ELIMINAR');
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

    public function verEncuesta(Request $request)
    {
        if($request->ajax()) {
            $encuestas = UtilidadesController::getDetalleEncuesta($request->id);
           // $mprima = UtilidadesController::getMprima($encuestas[0]->rif);
           /* $req = UtilidadesController::getRequerimiento($encuestas[0]->rif);
            $logros = UtilidadesController::getLogro($encuestas[0]->rif);
            $rfi = UtilidadesController::getRqfinanciamiento($encuestas[0]->rif);*/
            $returnHTML = view('sistema.encuestas.detalle', compact('encuestas'/*,'mprima','req','logros', 'rfi'*/))->render();
            return $returnHTML;

           // return response()->json($encuestas);
        }
    }


}
