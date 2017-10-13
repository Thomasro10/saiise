<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Empresa;
use App\Estado;
use App\Log;

class EmpresaController extends Controller
{
    //
    public function getIndex()
    {
        $edos = Estado::orderBy('nombre', 'asc')->get();
        return view('sistema.empresa.empresa', compact('edos'));
    }

    public function getData(Request $request)
    {
        $encuestas = DB::table('empresas')
            ->join('estados', 'empresas.edo', '=', 'estados.id')
            ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
            ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
            ->join('users', 'empresas.usuario', '=', 'users.id')
            ->select('empresas.id',
                    'empresas.empresa',
                    'empresas.rif',
                    'empresas.clasificacion',
                    'empresas.sector',
                    'empresas.rubro',
                    'empresas.convenio',
                    'empresas.direccion',
                    'empresas.contacto',
                    'empresas.ci_cont',
                    'empresas.cargo_cont',
                    'empresas.telf',
                    'empresas.email',
                    'users.nombre',
                    'estados.nombre AS estado',
                    'municipios.nombre AS municipio',
                    'parroquias.nombre AS parroquia');
        //->where('oficina.nombre', 'NOT ILIKE', '%DELETE%');
        if(Auth::user()->rol == 30){
            $encuestas->where('empresas.rif', 'ilike', Auth::user()->empresa);
        }

        if(Auth::user()->rol == 2){
            $encuestas->where('empresas.usuario', '=', Auth::user()->id);
        }

        return Datatables::of($encuestas)
            ->addColumn('accion', function ($encuestas) {
                $class = (!empty($encuestas->nombre))? 'style-success': '';
                $btn = '';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 2 || Auth::user()->rol == 4 || Auth::user()->rol == 30) {
                    $btn .= '<a href="javascript:void(0);" title="Actualizar" onclick="findUpdateEnc('.$encuestas->id.')"><i class="fa fa-edit fa-lg fa-border"></i></a> ';
                    if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                        $btn .='<a href="javascript:void(0);" title="Eliminar" onclick="deleteEnc('.$encuestas->id.')"><i class="fa fa-trash-o fa-lg fa-border style-danger"></i></a> ';
                        $btn .= '<a href="javascript:void(0);" title="Asignar responsable '.$encuestas->nombre.'" onclick="asigResp('.$encuestas->id.')"><i class="fa fa-user-plus fa-lg fa-border '.$class.'"></i></a> ';
                    }
                }


                $btn .='<a href="javascript:void(0);" title="Detalle" onclick="viewEnc('.$encuestas->id.')"><i class="fa fa-eye fa-lg fa-border"></i></a>';

                return  $btn;
            })
            /*->filterColumn('fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })*/
            ->rawColumns(['accion'])
            ->make(true);

    }

    public function agregarEmpresa(Request $request)
    {
        try{
            $empresa = new Empresa();

            $empresa->empresa      =mb_strtoupper($request->empresa);
            $empresa->rif          =mb_strtoupper($request->rif);
            $empresa->clasificacion          =mb_strtoupper($request->clasificacion );
            $empresa->edo          =mb_strtoupper($request->edo);
            $empresa->mcpio        =mb_strtoupper($request->mcpio);
            $empresa->pquia        =mb_strtoupper($request->pquia);
            $empresa->direccion    =mb_strtoupper($request->direccion);
            $empresa->contacto     =mb_strtoupper($request->contacto);
            if($request->ci_cont != ''){
                $empresa->ci_cont      =mb_strtoupper($request->ci_cont);
            }


            $empresa->cargo_cont   =mb_strtoupper($request->cargo_cont);
            $empresa->telf         =mb_strtoupper($request->telf);
            $empresa->email        =mb_strtoupper($request->email);

            $empresa->rubro        =mb_strtoupper($request->rubro);
            $empresa->sector       =mb_strtoupper($request->sector);
            $empresa->convenio        =mb_strtoupper($request->convenio);

           // if(Auth::user()->rol == 2){
                $empresa->usuario = Auth::user()->id;
           // }

            if($empresa->save()){
                UtilidadesController::setLog(Auth::user()->user, 'EMPRESA', 'AGREGAR', mb_strtoupper($request->rif));
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

    public function buscarEmpresa(Request $request)
    {
        if($request->ajax()) {
            $encuestas = DB::table('empresas')
                ->join('estados', 'empresas.edo', '=', 'estados.id')
                ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
                ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
                ->select('empresas.id',
                    'empresas.empresa',
                    'empresas.rif',
                    'empresas.clasificacion',
                    'empresas.sector',
                    'empresas.rubro',
                    'empresas.convenio',
                    'empresas.edo',
                    'empresas.mcpio',
                    'empresas.pquia',
                    'empresas.direccion',
                    'empresas.contacto',
                    'empresas.ci_cont',
                    'empresas.cargo_cont',
                    'empresas.telf',
                    'empresas.email',
                    'estados.nombre AS estado',
                    'municipios.nombre AS municipio',
                    'parroquias.nombre AS parroquia')
                ->where('empresas.id', '=', $request->id)->get();
            return response()->json($encuestas);
        }
    }

    public function actualizarEmpresa(Request $request)
    {
        try{

            $log = DB::table('logs')
                ->where('empresa', $request->id_emp_rif)
                ->update(['empresa' => $request->rif]);

            if($log){
                $empresa = Empresa::find($request->id);
                $empresa->empresa      =mb_strtoupper($request->empresa);
                $empresa->rif          =mb_strtoupper($request->rif);
                $empresa->clasificacion          =mb_strtoupper($request->clasificacion );
                $empresa->edo          =mb_strtoupper($request->edo);
                $empresa->mcpio        =mb_strtoupper($request->mcpio);
                $empresa->pquia        =mb_strtoupper($request->pquia);
                $empresa->direccion    =mb_strtoupper($request->direccion);
                $empresa->contacto     =mb_strtoupper($request->contacto);
                if($request->ci_cont != ''){
                    $empresa->ci_cont      =mb_strtoupper($request->ci_cont);
                }
                $empresa->cargo_cont   =mb_strtoupper($request->cargo_cont);
                $empresa->telf         =mb_strtoupper($request->telf);
                $empresa->email        =mb_strtoupper($request->email);
                $empresa->rubro        =mb_strtoupper($request->rubro);
                $empresa->sector       =mb_strtoupper($request->sector);
                $empresa->convenio     =mb_strtoupper($request->convenio);


                if($empresa->update()){
                    UtilidadesController::setLog(Auth::user()->user, 'EMPRESAS', 'ACTUALIZAR', mb_strtoupper($request->rif));
                    return response()->json(array(
                        'status' => 1,
                        'msg' => 'Registro actualizado',
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

    public function eliminarEmpresa(Request $request)
    {
        if($request->ajax()) {
            try{
                $deletedRows = Empresa::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'EMPRESAS', 'ELIMINAR - '.$request->id);
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

    public function verEmpresa(Request $request)
    {
        if($request->ajax()) {
            $encuestas = DB::table('empresas')
                ->join('estados', 'empresas.edo', '=', 'estados.id')
                ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
                ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
                ->select('empresas.id',
                    'empresas.empresa',
                    'empresas.clasificacion',
                    'empresas.sector',
                    'empresas.rubro',
                    'empresas.convenio',
                    'empresas.rif',
                    'empresas.edo',
                    'empresas.mcpio',
                    'empresas.pquia',
                    'empresas.direccion',
                    'empresas.contacto',
                    'empresas.ci_cont',
                    'empresas.cargo_cont',
                    'empresas.telf',
                    'empresas.email',
                    'estados.nombre AS estado',
                    'municipios.nombre AS municipio',
                    'parroquias.nombre AS parroquia')
                ->where('empresas.id', '=', $request->id)->get();
            $returnHTML = view('sistema.empresa.detalle', compact('encuestas'))->render();
            return $returnHTML;
        }
    }

    public function asigResponsable(Request $request)
    {
        if($request->ajax()) {
            try{
                Empresa::where('id', $request->id_emp)->update(['usuario' => $request->resp]);
                UtilidadesController::setLog(Auth::user()->user, 'EMPRESA', 'ASIGNAR RESPONSABLE', $request->id_emp.'-'.$request->resp);
                return response()->json(array(
                    'status' => 1,
                    'msg' => 'Responsable Asignado',
                ));
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
}
