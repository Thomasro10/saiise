<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\User;
use App\Rol;

class UserController extends Controller
{
    //
    public function getIndex()
    {
        $rol = Rol::orderBy('id', 'asc')->get();
        return view('sistema.usuarios.usuarios', compact( 'rol'));
    }

    public function getData(Request $request)
    {
        $usuarios = DB::table('users')
            ->join('roles', 'users.rol', '=', 'roles.id_acceso')
            ->select('users.id',
                'users.nombre',
                'users.email',
                'users.user',
                'roles.descripcion AS nrol',
                'users.status');


        $datatables = Datatables::of($usuarios)
            ->addColumn('accion', function ($usuario) {
                $buttons ='';
                $buttons .= '<a href="javascript:void(0);" title="Actualizar" onclick="findUpdateUsu('.$usuario->id.')"><i class="fa fa-edit fa-lg fa-border"></i></a> ';
                if(Auth::user()->rol == 10 ) {
                    $buttons .= '<a href="javascript:void(0);" title="Eliminar" onclick="deleteUsu('.$usuario->id.')"><i class="fa fa-trash-o fa-lg fa-border style-danger"></i></a> ';
                }
                $buttons .= '<a href="javascript:void(0);"  title="Resetear clave" onclick="resetClaveUsu('.$usuario->id.')"><i class="fa fa-refresh fa-lg fa-border"></i></a>';


                if($usuario->status == 0){
                    $buttons .= ' <a href="javascript:void(0);"  title="Activar" onclick="actDesUsu('.$usuario->id.')"><i class="fa fa-check-square-o fa-lg fa-border"></i></a>';
                }
                else{
                    $buttons .= ' <a href="javascript:void(0);"  title="desactivar" onclick="actDesUsu('.$usuario->id.')"><i class="fa fa-square-o fa-lg fa-border"></i></a>';
                }
                return $buttons;
            })
            ->editColumn('status', function ($usuario) {
                if(!empty($usuario->status == 1)){
                    return 'SI';
                }
                else{
                    return 'NO';
                }
            })
            ->rawColumns(['accion','activo']);



        return $datatables->make(true);
    }

    public function agregarUsuario(Request $request)
    {
        try{
            $usuario = new User();


            $usuario->nombre       = mb_strtoupper($request->nom);
            $usuario->email        = mb_strtoupper($request->email);
            $usuario->rol          = mb_strtoupper($request->rol);
            $usuario->status       = mb_strtoupper($request->act);
            $usuario->cnd          = trim(mb_strtoupper($request->cnd));
            $usuario->empresa      = mb_strtoupper($request->rif);
            $usuario->password     = bcrypt('123456');
            if($request->rol == 30) {
                $usuario->user = trim(mb_strtolower(str_replace('-', '', $request->rif)));
            }
            else{
                $usuario->user = trim(mb_strtolower($request->usu));
            }
            /*
                if (preg_match("/[JGVEC][-][0-9]{8}[-][0-9]$/i", )) {
                    echo "Se encontró una coincidencia.";
                } else {
                    echo "No se encontró ninguna coincidencia.";
                }

            }*/


            if($usuario->save()){
                UtilidadesController::setLog(Auth::user()->user, 'USUARIOS', 'AGREGAR - '.trim(mb_strtolower($request->usu)));
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

    public function buscarUsuario(Request $request)
    {
        if($request->ajax()) {
            $usuario = DB::table('users')
                ->join('roles', 'users.rol', '=', 'roles.id_acceso')
                ->select('users.id',
                    'users.nombre',
                    'users.email',
                    'users.user',
                    'users.rol',
                    'users.empresa',
                    'users.cnd',
                    'roles.descripcion AS nrol',
                    'users.status')
                ->where('users.id', '=', $request->id)->get();
            return response()->json($usuario);
        }
    }

    public function actualizarUsuario(Request $request)
    {
        try{
            $usuario = User::find($request->id_usu);

            $usuario->nombre       = mb_strtoupper($request->nom);
            $usuario->email        = mb_strtoupper($request->email);
            $usuario->rol          = mb_strtoupper($request->rol);
            $usuario->status       = mb_strtoupper($request->act);
            $usuario->cnd          = trim(mb_strtoupper($request->cnd));
            $usuario->empresa      = mb_strtoupper($request->rif);


            if($request->rol == 30) {
                $usuario->user = trim(mb_strtolower(str_replace('-', '', $request->rif)));
            }
            else{
                $usuario->user = trim(mb_strtolower($request->usu));
            }


            if($usuario->update()){
                UtilidadesController::setLog(Auth::user()->user, 'USUARIOS', 'ACTUALIZAR - '.trim(mb_strtolower($request->usu)));
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

    public function resetClaveUsuario(Request $request)
    {
        try{
            $usuario = User::find($request->id);

            $usuario->password    = bcrypt('123456');


            if($usuario->update()){
                UtilidadesController::setLog(Auth::user()->user, 'USUARIOS', 'RESET CLAVE - '.$request->id);
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

    public function eliminarUsuario(Request $request)
    {
        try{
            if($request->ajax()) {

                $deletedRows = User::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'USUARIOS', 'ELIMINAR - '.$request->id);
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

    public function activarDesactivarUsuario(Request $request)
    {
        try{
            if($request->ajax()) {
                $usuario = User::where('id',$request->id)->first();
                if($usuario->status == 0 ){
                    $usuario->status = 1;
                }
                else{
                    $usuario->status = 0;
                }

                if($usuario->update()){
                    UtilidadesController::setLog(Auth::user()->user, 'USUARIOS', 'ACTIVAR-DESACTIVAR - '.$request->id);

                    return response()->json(array(
                        'status' => 1,
                        'msg' => 'Registro actualizado',
                    ));
                }
                else{
                    return response()->json(array(
                        'status' => 0,
                        'msg' => 'No se pudo actualizar el registro',
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
