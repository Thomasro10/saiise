<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\URL;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Exception;
use Image;
use PDF;

use App\Estado;
use App\Visita;
use App\VisitasProduccion;
use App\VisitasComercializacion;
use App\VisitasMPrima;
use App\VisitasInvPer;


class VisitaController extends Controller
{
    //
    public function getIndex()
    {
        $edos = Estado::orderBy('nombre', 'asc')->get();
        return view('sistema.visitas.visitas', compact('edos'));
    }

    public function getData(Request $request)
    {
        $visitas = DB::table('vis_visitas')
            ->join('empresas', 'vis_visitas.emp_rif', '=', 'empresas.rif')
            ->join('estados', 'empresas.edo', '=', 'estados.id')
            ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
            ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
            ->select('vis_visitas.id',
                'empresas.rif',
                'empresas.empresa',
                'estados.nombre AS edo',
                'municipios.nombre AS mcpio',
                'parroquias.nombre AS pquia',
                'empresas.direccion',
                DB::raw("to_char(vis_visitas.fecha, 'DD/MM/YYYY') as fecha"),
                'vis_visitas.operatividad',
                'vis_visitas.ciiu',
                'vis_visitas.tipo_emp',
                'vis_visitas.trabajadores',
                'vis_visitas.tnum',
                'vis_visitas.servicios',
                'vis_visitas.objeto',
                'vis_visitas.l_prod',
                'vis_visitas.nc_prod',
                'vis_visitas.nc_mprima',
                'vis_visitas.pclientes',
                'vis_visitas.pedo',
                'vis_visitas.pproductivo',
                'vis_visitas.observacion')
            ->whereColumn('empresas.mcpio', 'municipios.id')
            ->whereColumn('empresas.pquia' , 'parroquias.id');
       /* if(Auth::user()->rol == 30){
            $encuestas->where('empresas.rif', 'ilike', Auth::user()->empresa);
        }

        if(Auth::user()->rol == 2){
            $encuestas->where('empresas.usuario', '=', Auth::user()->id);
        }*/

        $datatables = Datatables::of($visitas)
            ->addColumn('accion', function ($vis) {
                $btn ='';
                $btn .= '<a href="javascript:void(0);" title="Actualizar" onclick="findUpdateVis('.$vis->id.')"><i class="fa fa-edit fa-lg fa-border"></i></a> ';
                if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                    $btn .='<a href="javascript:void(0);" title="Eliminar" onclick="deleteVis('.$vis->id.')"><i class="fa fa-trash-o fa-lg fa-border style-danger"></i></a> ';
                }

                $btn .= '<a href="javascript:void(0);" onclick="cargarProduccion('.$vis->id.')" title="Cargar producción"><i class="fa fa-cogs fa-lg fa-border"></i></a> ';
                $btn .= '<a href="javascript:void(0);" onclick="cargarMPrima('.$vis->id.')" title="Cargar materia prima"><i class="fa fa-th fa-lg fa-border"></i></a> ';
                $btn .= '<a href="javascript:void(0);" onclick="cargarComercializacion('.$vis->id.')" title="Cargar comercialización"><i class="fa fa-truck fa-lg fa-border"></i></a> ';
                $btn .= '<a href="javascript:void(0);" onclick="cargarInvPer('.$vis->id.')" title="Cargar inversiones/permisos)"><i class="fa fa-money fa-lg fa-border"></i></a> ';
                $btn .= '<a href="javascript:void(0);" onclick="verFichaVisitas('.$vis->id.')" title="Ver visita(s)"><i class="fa fa-eye fa-lg fa-border"></i></a> ';


                return $btn;
            })
            ->filterColumn('fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(vis_visitas.fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })
            ->rawColumns(['accion']);

        if ($datatables->request->get('fecha_inicio') && $datatables->request->get('fecha_fin') ) {
            //$datatable->where('solicitudes.fecha', '=', "$name%");
            //$datatables->whereBetween('logs.fecha', [ $datatables->request->get('fecha_inicio').' 00:00:00', $datatables->request->get('fecha_fin').' 23:59:59' ]);
            $datatables->whereBetween('vis_visitas.fecha', [ $datatables->request->get('fecha_inicio'), $datatables->request->get('fecha_fin')]);

        }

            return $datatables->make(true);

    }

    public function agregarVisitas(Request $request)
    {
        try{
            $arr = array_map('strtoupper', $request->except(['_token', 'empresa']));

            if(Visita::create($arr)){
                UtilidadesController::setLog(Auth::user()->user, 'VISITA', 'AGREGAR', mb_strtoupper($request->emp_rif));
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

    public function buscarVisitas(Request $request)
    {
        if($request->ajax()) {
            $visitas = DB::table('vis_visitas')
                ->join('empresas', 'vis_visitas.emp_rif', '=', 'empresas.rif')
                ->select('vis_visitas.id',
                    'empresas.rif',
                    'empresas.empresa',
                    'vis_visitas.fecha',
                    'vis_visitas.operatividad',
                    'vis_visitas.ciiu',
                    'vis_visitas.tipo_emp',
                    'vis_visitas.trabajadores',
                    'vis_visitas.tnum',
                    'vis_visitas.servicios',
                    'vis_visitas.objeto',
                    'vis_visitas.l_prod',
                    'vis_visitas.nc_prod',
                    'vis_visitas.nc_mprima',
                    'vis_visitas.pclientes',
                    'vis_visitas.pedo',
                    'vis_visitas.pproductivo',
                    'vis_visitas.observacion')
                ->where('vis_visitas.id', '=', $request->id)->get();
            return response()->json($visitas);
        }
    }

    public function eliminarVisitas(Request $request)
    {
        if($request->ajax()) {
            try{

                $deletedRows = Visita::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'VISITAS', 'ELIMINAR -'.$request->id);
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

    public function verFichaVisita(Request $request)
    {
       //if($request->ajax()) {
        $visita = DB::table('vis_visitas')
            ->join('empresas', 'vis_visitas.emp_rif', '=', 'empresas.rif')
            ->join('estados', 'empresas.edo', '=', 'estados.id')
            ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
            ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
            ->select('vis_visitas.id',
                'empresas.rif',
                'empresas.empresa',
                'estados.nombre AS edo',
                'municipios.nombre AS mcpio',
                'parroquias.nombre AS pquia',
                'empresas.direccion',
                'empresas.sector',
                'empresas.contacto',
                'empresas.ci_cont',
                'empresas.telf',
                'empresas.email',
                DB::raw("to_char(vis_visitas.fecha, 'DD/MM/YYYY') as fecha"),
                'vis_visitas.operatividad',
                'vis_visitas.ciiu',
                'vis_visitas.tipo_emp',
                'vis_visitas.trabajadores',
                'vis_visitas.tnum',
                'vis_visitas.servicios',
                'vis_visitas.objeto',
                'vis_visitas.l_prod',
                'vis_visitas.nc_prod',
                'vis_visitas.nc_mprima',
                'vis_visitas.pclientes',
                'vis_visitas.pedo',
                'vis_visitas.pproductivo',
                'vis_visitas.observacion',
                'vis_visitas.foto1',
                'vis_visitas.foto2',
                'vis_visitas.foto3',
                'vis_visitas.foto4')
            ->whereColumn('empresas.mcpio', 'municipios.id')
            ->whereColumn('empresas.pquia' , 'parroquias.id')
            ->where('vis_visitas.id', $request->id)->get();
           $vprod = VisitasProduccion::where('vis_id', $request->id)->get();
           $vmpri = VisitasMPrima::where('vis_id', $request->id)->get();
           $vcom = VisitasComercializacion::where('vis_id', $request->id)->get();
           $vinvp = VisitasInvPer::where('vis_id', $request->id)->get();

           return view('sistema.visitas.ficha', compact('visita', 'vprod', 'vmpri', 'vcom', 'vinvp'))->render();
       // }
    }


    public function actualizarVisitas(Request $request)
    {
        try{
            $arr = array_map('strtoupper', $request->except(['_token', 'empresa', 'id']));

            if(Visita::updateOrCreate(['id' => $request->id], $arr)){
                UtilidadesController::setLog(Auth::user()->user, 'VISITAS', 'ACTUALIZAR', mb_strtoupper($request->rif));
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

    public function agregarVProduccion(Request $request)
    {
        try{
            $arr = UtilidadesController::cambiarComasNumeroArray($request->except(['_token']));
            $arr = array_map('strtoupper', $arr );

            if(VisitasProduccion::create($arr)){
                UtilidadesController::setLog(Auth::user()->user, 'VISITA-PRODUCCION', 'AGREGAR', mb_strtoupper($request->vis_id));
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

    public function agregarVMPrima(Request $request)
    {
        try{
            $arr = UtilidadesController::cambiarComasNumeroArray($request->except(['_token']));
            $arr = array_map('strtoupper', $arr );

            if(VisitasMPrima::create($arr)){
                UtilidadesController::setLog(Auth::user()->user, 'VISITA-MATERIA PRIMA', 'AGREGAR', mb_strtoupper($request->vis_id));
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

    public function agregarComercializacion(Request $request)
    {
        try{
            $arr = UtilidadesController::cambiarComasNumeroArray($request->except(['_token']));
            $arr = array_map('strtoupper', $arr );

            if(VisitasComercializacion::create($arr)){
                UtilidadesController::setLog(Auth::user()->user, 'VISITA-COMERCIALIZACION', 'AGREGAR', mb_strtoupper($request->vis_id));
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

    public function agregarInvPer(Request $request)
    {
        try{
            $arr = UtilidadesController::cambiarComasNumeroArray($request->except(['_token']));
            $arr = array_map('strtoupper', $arr );

            if(VisitasInvPer::create($arr)){
                UtilidadesController::setLog(Auth::user()->user, 'VISITA-INVERSION/PERMISOS', 'AGREGAR', mb_strtoupper($request->vis_id));
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

    public function getDataPro(Request $request)
    {
        $visitas = DB::table('vis_produccion')
            ->select(
                "id",
                "producto",
                "cod_aran",
                "medida",
                "cinstalada",
                "coperativa",
                "prodaant",
                "prodact",
                "prodmeta")
            ->where('vis_produccion.vis_id', $request->id);

        $datatables = Datatables::of($visitas)
            ->editColumn('cinstalada', function ($vis) {
                return number_format($vis->cinstalada, 2, ",", ".");
            })
            ->editColumn('coperativa', function ($vis) {
                return number_format($vis->coperativa, 2, ",", ".");
            })
            ->editColumn('prodaant', function ($vis) {
                return number_format($vis->prodaant, 2, ",", ".");
            })
            ->editColumn('prodact', function ($vis) {
                return number_format($vis->prodact, 2, ",", ".");
            })
            ->editColumn('prodmeta', function ($vis) {
                return number_format($vis->prodmeta, 2, ",", ".");
            })
            ->addColumn('accion', function ($vis) {
                $btn ='';
                    $btn .='<a href="javascript:void(0);" title="Eliminar" onclick="deleteVPro('.$vis->id.')"><i class="fa fa-trash-o fa-lg fa-border style-danger"></i></a> ';
                return $btn;
            })
            ->rawColumns(['accion']);

        return $datatables->make(true);

    }

    public function getDataMPrima(Request $request)
    {
        $visitas = DB::table('vis_mprima')
            ->select(
                "id",
                "producto",
                "proveedor",
                "cod_aran",
                "medida",
                "creq",
                "cdis")
            ->where('vis_mprima.vis_id', $request->id);

        $datatables = Datatables::of($visitas)
            ->editColumn('creq', function ($vis) {
                return number_format($vis->creq, 2, ",", ".");
            })
            ->editColumn('cdis', function ($vis) {
                return number_format($vis->cdis, 2, ",", ".");
            })
            ->addColumn('accion', function ($vis) {
                $btn ='';
                $btn .='<a href="javascript:void(0);" title="Eliminar" onclick="deleteVMPri('.$vis->id.')"><i class="fa fa-trash-o fa-lg fa-border style-danger"></i></a> ';
                return $btn;
            })
            ->rawColumns(['accion']);

        return $datatables->make(true);

    }

    public function getDataComercializacion(Request $request)
    {
        $visitas = DB::table('vis_comercializacion')
            ->select(
                "id",
                "producto",
                "cod_aran",
                "minterno",
                "exportacion",
                "preciobs",
                "ventanac",
                "ventanacest",
                "exportacionusd",
                "exportacionestusd")
            ->where('vis_comercializacion.vis_id', $request->id);

        $datatables = Datatables::of($visitas)
            ->editColumn('preciobs', function ($vis) {
                return number_format($vis->preciobs, 2, ",", ".");
            })
            ->editColumn('ventanac', function ($vis) {
                return number_format($vis->ventanac, 2, ",", ".");
            })
            ->editColumn('ventanacest', function ($vis) {
                return number_format($vis->ventanacest, 2, ",", ".");
            })
            ->editColumn('exportacionusd', function ($vis) {
                return number_format($vis->exportacionusd, 2, ",", ".");
            })
            ->editColumn('exportacionestusd', function ($vis) {
                return number_format($vis->exportacionestusd, 2, ",", ".");
            })
            ->addColumn('accion', function ($vis) {
                $btn ='';
                $btn .='<a href="javascript:void(0);" title="Eliminar" onclick="deleteCom('.$vis->id.')"><i class="fa fa-trash-o fa-lg fa-border style-danger"></i></a> ';
                return $btn;
            })
            ->rawColumns(['accion']);

        return $datatables->make(true);

    }

    public function getDataInvPer(Request $request)
    {
        if($request->ajax()) {
            $inv = VisitasInvPer::where('vis_id', $request->id)->get();
            $returnHTML = view('sistema.visitas.invper', compact('inv'))->render();
            return $returnHTML;
        }
    }

    public function eliminarProduccion(Request $request)
    {
        if($request->ajax()) {
            try{
                $deletedRows = VisitasProduccion::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'VISITAS-PRODUCCION', 'ELIMINAR -'.$request->id);
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

    public function eliminarMPrima(Request $request)
    {
        if($request->ajax()) {
            try{
                $deletedRows = VisitasMPrima::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'VISITAS-MATERIA PRIMA', 'ELIMINAR -'.$request->id);
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

    public function eliminarComercializacion(Request $request)
    {
        if($request->ajax()) {
            try{
                $deletedRows = VisitasComercializacion::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'VISITAS-COMERCIALIZACION', 'ELIMINAR -'.$request->id);
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

    public function eliminarInvPer(Request $request)
    {
        if($request->ajax()) {
            try{
                $deletedRows = VisitasInvPer::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'VISITAS-INVERSION/PERMISOS', 'ELIMINAR -'.$request->id);
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

    public function subirFoto(Request $request)
    {
        try{
            //dd($request->all());
            $image = $request->file('file');
            $name = explode('.', $image->getClientOriginalName());
            $input['imagename'] = time().'_'.$name[0].'.'.$image->getClientOriginalExtension();
            //dd($image->getRealPath());
            $destinationPath = public_path().'/imagenes';

            if($image->move($destinationPath, $input['imagename'])){
                $img = Image::make($destinationPath.'/'.$input['imagename']);
                $img->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                if($img->save($destinationPath.'/'.$input['imagename'],90)){
                    $visita = Visita::find($request->id);
                    switch ($request->cnd) {
                        case 'foto1':
                            $visita->foto1 = $input['imagename'];
                            break;
                        case 'foto2':
                            $visita->foto2 = $input['imagename'];
                            break;
                        case 'foto3':
                            $visita->foto3 = $input['imagename'];
                            break;
                        case 'foto4':
                            $visita->foto4 = $input['imagename'];
                            break;
                    }

                    if($visita->update()){
                        UtilidadesController::setLog(Auth::user()->user, 'VISITAS-AGREGAR FOTO', 'ACTUALIZAR', mb_strtoupper($request->cnd));
                        return response()->json(array(
                            'status' => 1,
                            'msg' => 'Imagen cargada',
                        ));
                    }
                }
            };

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

    public function eliminarFoto(Request $request)
    {
        if($request->ajax()) {
            try{

                $error = 0;

                switch ($request->cnd){
                    case 'foto1':
                        $foto = DB::table('vis_visitas')->select('foto1')->where('id', $request->id)->first();
                        if(unlink(public_path().'/imagenes/'.$foto->foto1)) {
                            $visita = Visita::find($request->id);
                            $visita->foto1 = '';
                            $visita->update();
                            $error = 0;
                        }
                        else{
                            $error = 1;
                        }

                    break;
                    case 'foto2':
                        $foto = DB::table('vis_visitas')->select('foto2')->where('id', $request->id)->first();
                        if(unlink(public_path().'/imagenes/'.$foto->foto2)) {
                            $visita = Visita::find($request->id);
                            $visita->foto2 = '';
                            $visita->update();
                            $error = 0;
                        }
                        else{
                            $error = 1;
                        }
                    break;
                    case 'foto3':
                        $foto = DB::table('vis_visitas')->select('foto3')->where('id', $request->id)->first();
                        if(unlink(public_path().'/imagenes/'.$foto->foto3)) {
                            $visita = Visita::find($request->id);
                            $visita->foto3 = '';
                            $visita->update();
                            $error = 0;
                        }
                        else{
                            $error = 1;
                        }
                    break;
                    case 'foto4':
                        $foto = DB::table('vis_visitas')->select('foto4')->where('id', $request->id)->first();
                        if(unlink(public_path().'/imagenes/'.$foto->foto4)) {
                            $visita = Visita::find($request->id);
                            $visita->foto4 = '';
                            $visita->update();
                            $error = 0;
                        }
                        else{
                            $error = 1;
                        }
                    break;
                }

                if($error == 0){
                    return response()->json(array(
                        'status' => 1,
                        'msg' => 'Foto eliminada'
                    ));
                }
                else{
                    return response()->json(array(
                        'status' => 0,
                        'msg' => 'No se pudo eliminar la foto'
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

    public function generarFicha(Request $request)
    {
        $visita = DB::table('vis_visitas')
            ->join('empresas', 'vis_visitas.emp_rif', '=', 'empresas.rif')
            ->join('estados', 'empresas.edo', '=', 'estados.id')
            ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
            ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
            ->select('vis_visitas.id',
                'empresas.rif',
                'empresas.empresa',
                'estados.nombre AS edo',
                'municipios.nombre AS mcpio',
                'parroquias.nombre AS pquia',
                'empresas.direccion',
                'empresas.sector',
                'empresas.contacto',
                'empresas.ci_cont',
                'empresas.telf',
                'empresas.email',
                DB::raw("to_char(vis_visitas.fecha, 'DD/MM/YYYY') as fecha"),
                'vis_visitas.operatividad',
                'vis_visitas.ciiu',
                'vis_visitas.tipo_emp',
                'vis_visitas.trabajadores',
                'vis_visitas.tnum',
                'vis_visitas.servicios',
                'vis_visitas.objeto',
                'vis_visitas.l_prod',
                'vis_visitas.nc_prod',
                'vis_visitas.nc_mprima',
                'vis_visitas.pclientes',
                'vis_visitas.pedo',
                'vis_visitas.pproductivo',
                'vis_visitas.observacion',
                'vis_visitas.foto1',
                'vis_visitas.foto2',
                'vis_visitas.foto3',
                'vis_visitas.foto4')
            ->whereColumn('empresas.mcpio', 'municipios.id')
            ->whereColumn('empresas.pquia' , 'parroquias.id')
            ->where('vis_visitas.id', $request->id)->get();
        $vprod = VisitasProduccion::where('vis_id', $request->id)->get()->toArray();
        $vmpri = VisitasMPrima::where('vis_id', $request->id)->get()->toArray();
        $vcom = VisitasComercializacion::where('vis_id', $request->id)->get()->toArray();
        $vinvp = VisitasInvPer::where('vis_id', $request->id)->get();

        $avprod = array_chunk($vprod, 12, true);

        $avmpri = array_chunk($vmpri, 12, true);
        $avcom = array_chunk($vcom, 12, true);


        $pdf = PDF::loadView('sistema.visitas.pdf', compact('visita', 'avprod', 'avmpri', 'avcom', 'vinvp'), [], ['orientation' => 'L']);
        return $pdf->download('ficha.pdf');

        /*$view =  \View::make('sistema.visitas.pdf', )->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setOptions(['isPhpEnabled' => true]);
        $pdf->setPaper('L', 'landscape');
        return $pdf->download('ficha.pdf');*/
    }

    public function ppdf()
    {
        $pdf = PDF::loadView('sistema.visitas.mpdf', []);
        return $pdf->stream('document.pdf');
    }

}
