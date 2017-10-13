<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    //
    public function getIndex()
    {
        return view('sistema.logs.logs');
    }

    public function getData(Request $request)
    {
        $logs = DB::table('logs')
            ->select('logs.id',
                'logs.usuario',
                'logs.modulo',
                'logs.accion',
                'logs.empresa',
                DB::raw("to_char(logs.fecha, 'DD/MM/YYYY HH24:MI:SS') as fecha"));



        $datatables = Datatables::of($logs)
            ->filterColumn('fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(fecha, 'DD/MM/YYYY HH24:MI:SS') ilike ?", ["%$keyword%"]);
            });

        if ($datatables->request->get('fecha_inicio') && $datatables->request->get('fecha_fin') ) {
            //$datatable->where('solicitudes.fecha', '=', "$name%");
            //$datatables->whereBetween('logs.fecha', [ $datatables->request->get('fecha_inicio').' 00:00:00', $datatables->request->get('fecha_fin').' 23:59:59' ]);
            $datatables->whereBetween(DB::raw("CAST(logs.fecha AS date)"), [ $datatables->request->get('fecha_inicio'), $datatables->request->get('fecha_fin')]);

        }

        return $datatables->make(true);
    }
}
