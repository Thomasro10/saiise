<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;

class ConsultasController extends Controller
{
    //
    public function getIndex()
    {
        return view('sistema.consultas.consultas');
    }
}
