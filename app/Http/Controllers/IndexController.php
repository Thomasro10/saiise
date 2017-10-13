<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Session;
use Exception;

use App\User;
use App\Estado;
use App\Empresa;

class IndexController extends Controller
{
    //
    public function getIndex()
    {
        return view('sistema.index');
    }

    public function getLogin()
    {
        return view('sistema.acceso.login');
    }

    public function postLogin(Request $request)
    {
        try{
            if(!Auth::attempt(['user' => $request->user, 'password' => $request->password, 'status' => 1 ])){
                return response()->json(array(
                    'status' => '0',
                    'msg' => 'Error, no se pudo validar sus datos o el usuario esta inactivo',
                ));
            }
            else{
                UtilidadesController::setLog($request->user, 'ACCESO',$request->ip() );
                return response()->json(array('status' => '1'));
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

    public function getLogout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('sistema.acceso');
    }

    public function cambiarClave(Request $request)
    {
        try{
        $usuario = User::find($request['id']);
        $usuario->password    =bcrypt($request['pass1']);
        $usuario->vez_p   =1;

        $usuario->update();
        UtilidadesController::setLog(Auth::user()->user, 'CAMBIO DE CLAVE','CORRECTO' );
        return response()->json(array(
                'status' => 1,
                'msg' => 'Clave cambiada',
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

    public function getRegistro()
    {
        $edos = Estado::orderBy('nombre', 'asc')->get();
        return view('sistema.acceso.registro', compact('edos'));
    }

    public function agregarRegistro(Request $request)
    {
        try{
            DB::beginTransaction();
            $count = 0;
            $empresa = new Empresa();
            $usuario = new User();

            $empresa->empresa      =mb_strtoupper($request->empresa);
            $empresa->rif          =mb_strtoupper($request->rif);
            $empresa->clasificacion         =mb_strtoupper($request->clasificacion);
            $empresa->edo          =mb_strtoupper($request->edo);
            $empresa->mcpio        =mb_strtoupper($request->mcpio);
            $empresa->pquia        =mb_strtoupper($request->pquia);
            $empresa->direccion    =mb_strtoupper($request->direccion);
            $empresa->contacto     =mb_strtoupper($request->contacto);
            $empresa->ci_cont      =mb_strtoupper($request->ci_cont);
            $empresa->cargo_cont   =mb_strtoupper($request->cargo_cont);
            $empresa->telf         =mb_strtoupper($request->telf);
            $empresa->email        =mb_strtoupper($request->email);

            $usuario->nombre      =mb_strtoupper($request->empresa);
            $usuario->email       =mb_strtoupper($request->email);
            $usuario->user        =mb_strtolower(str_replace('-', '', $request->rif));
            $usuario->password    =bcrypt('123456');
            $usuario->rol         =30;
            $usuario->status      =1;
            $usuario->empresa     =mb_strtoupper($request->rif);


            //$encuestas->obstaculos =mb_strtoupper((empty($request->obstaculos))? '' : implode(',',$request->obstaculos));

            if($empresa->save()){ $count ++; }
            if($usuario->save()){ $count ++; }

            if($count == 2){
                DB::commit();
                UtilidadesController::setLog(
                    $request->ci_cont.', '.mb_strtoupper($request->contacto).' - '.mb_strtoupper($request->cargo_cont),
                    'REGISTRO',
                    'AGREGAR - '.mb_strtoupper($request->empresa).' - '.$request->ip()
                    );
                return response()->json(array(
                    'status' => 1,
                    'msg' => 'Registro realizado satisfactoriamente<br>Su usuario es :'.mb_strtolower(str_replace('-', '', $request->rif)).' y la clave 123456',
                ));
            }
            else{
                DB::rollBack();
                return response()->json(array(
                    'status' => 0,
                    'msg' => 'Ha ocurrido un error, intentelo de nuevo y si el error persiste contacte al administrador del sistema'
                ));
            }
        }
        catch (QueryException $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => UtilidadesController::errorPostgres($e->getCode())
                ));
            }
        }
        catch (Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }
    }
}
