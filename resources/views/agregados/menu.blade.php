<!-- BEGIN MAIN MENU -->
<ul id="main-menu" class="gui-controls">
    <!-- BEGIN DASHBOARD -->
    <li>
        <a href="{{ URL::to('/') }}" @if(empty(Request::segment(1))) class="active" @endif>
            <div class="gui-icon"><i class="md md-home"></i></div>
            <span class="title">Inicio</span>
        </a>
    </li><!--end /menu-li -->
    <!-- END DASHBOARD -->

@if(Auth::user()->rol != 5 && Auth::user()->rol != 41 && Auth::user()->rol != 42 && Auth::user()->rol != 43 && Auth::user()->rol != 44)
    <!-- BEGIN Requerimientos -->
        <li class="gui-folder @if( Request::segment(1) == 'empresas' ) active expanded @endif">
            <a>
                <div class="gui-icon"><i class="fa fa-building"></i></div>
                <span class="title">Empresas</span>
            </a>
            <!--start submenu -->
            <ul>
                <li @if(Request::segment(1) == 'empresas') class="active expanded" @endif><a href="{!! route('sistema.empresas') !!}" ><span class="title">Información general</span></a></li>
            <!--@if(Auth::user()->rol != 10 || Auth::user()->rol != 1)
                <li @if(Request::segment(1) == 'visitas') class="active expanded" @endif><a href="{!! route('sistema.visitas') !!}" ><span class="title">Visitas</span></a></li>
								<li @if(Request::segment(1) == 'pproductivo') class="active expanded" @endif><a href="{!! route('sistema.pproductivo') !!}" ><span class="title">Proceso productivo</span></a></li>
								@endif-->
            </ul><!--end /submenu -->
        </li><!--end /menu-li -->
        <!-- END TABLES -->
@endif


@if (Auth::user()->rol != 30 &&  Auth::user()->rol != 41 && Auth::user()->rol != 42 && Auth::user()->rol != 43 && Auth::user()->rol != 44)
    <!-- BEGIN Materias primas -->
        <li class="gui-folder @if( Request::segment(1) == 'solicitudes' || Request::segment(1) == 'permisologia' || Request::segment(1) == 'mprima') active expanded @endif">
            <a>
                <div class="gui-icon"><i class="fa fa-folder"></i></div>
                <span class="title">Requerimientos / Solicitudes</span>
            </a>
            <!--start submenu -->
            <ul>
                <li @if(Request::segment(1) == 'solicitudes') class="active expanded" @endif><a href="{!! route('sistema.solicitudes') !!}" ><span class="title">Req / Solicitud</span></a></li>
                @if(Auth::user()->rol != 5 && Auth::user()->rol != 40 )
                    <li @if(Request::segment(1) == 'mprima') class="active expanded" @endif><a href="{!! route('sistema.mprima') !!}" ><span class="title">Detalle Materia prima</span></a></li>
                    <li @if(Request::segment(1) == 'permisologia') class="active expanded" @endif><a href="{!! route('sistema.permisologia') !!}" ><span class="title">Detalle Permisología</span></a></li>
                @endif
            </ul><!--end /submenu -->
        </li><!--end /menu-li -->
        <!-- END TABLES -->
    @endif

    @if(Auth::user()->rol == 10 ||  Auth::user()->rol == 1 ||  Auth::user()->rol == 40 || Auth::user()->rol == 41 || Auth::user()->rol == 42 || Auth::user()->rol == 43 || Auth::user()->rol == 44 )
        <li class="gui-folder @if( Request::segment(1) == 'eproyecto' ) active expanded @endif">
            <a>
                <div class="gui-icon"><i class="fa fa-list-ol"></i></div>
                <span class="title">Evaluación proyectos</span>
            </a>
            <!--start submenu -->
            <ul>
                @if(Auth::user()->rol == 10 ||  Auth::user()->rol == 1 ||  Auth::user()->rol == 40)
                    <li @if(Request::segment(2) == 'responsables') class="active expanded" @endif><a href="{!! route('sistema.eproyecto.responsables') !!}" ><span class="title">Responsables</span></a></li>
                @endif
                @if(Auth::user()->rol == 10 ||  Auth::user()->rol == 1 ||  Auth::user()->rol == 40 ||  Auth::user()->rol == 41)
                    <li @if(Request::segment(2) == 'legal') class="active expanded" @endif><a href="{!! route('sistema.eproyecto.legal') !!}" ><span class="title">Legal</span></a></li>
                @endif
                @if(Auth::user()->rol == 10 ||  Auth::user()->rol == 1 ||  Auth::user()->rol == 40 ||  Auth::user()->rol == 42)
                    <li @if(Request::segment(2) == 'economica') class="active expanded" @endif><a href="{!! route('sistema.eproyecto.economica') !!}" ><span class="title">Económico-social</span></a></li>
                @endif
                @if(Auth::user()->rol == 10 ||  Auth::user()->rol == 1 ||  Auth::user()->rol == 40 ||  Auth::user()->rol == 43)
                    <li @if(Request::segment(2) == 'financiera') class="active expanded" @endif><a href="{!! route('sistema.eproyecto.financiera') !!}" ><span class="title">Financiera</span></a></li>
                @endif
                @if(Auth::user()->rol == 10 ||  Auth::user()->rol == 1 ||  Auth::user()->rol == 40 ||  Auth::user()->rol == 44)
                    <li @if(Request::segment(2) == 'ingenieria') class="active expanded" @endif><a href="{!! route('sistema.eproyecto.ingenieria') !!}" ><span class="title">Ingeniería</span></a></li>
                @endif
                @if(Auth::user()->rol == 10 ||  Auth::user()->rol == 1 ||  Auth::user()->rol == 40)
                    <li @if(Request::segment(2) == 'reportes') class="active expanded" @endif><a href="{!! route('sistema.eproyecto.reportes') !!}" ><span class="title">Reportes</span></a></li>
                @endif
            </ul><!--end /submenu -->
        </li><!--end /menu-li -->
    @endif

<!-- BEGIN Materias primas -->
    @if(Auth::user()->rol != 5 && Auth::user()->rol != 40 && Auth::user()->rol != 41 && Auth::user()->rol != 42 && Auth::user()->rol != 43 && Auth::user()->rol != 44)
        <li class="gui-folder @if( Request::segment(1) == 'acciones' || Request::segment(1) == 'seguimiento' ) active expanded @endif">
            <a>
                <div class="gui-icon"><i class="fa fa-check-square-o"></i></div>
                <span class="title">Acciones</span>
            </a>
            <!--start submenu -->
            <ul>
                <li @if(Request::segment(1) == 'acciones') class="active expanded" @endif><a href="{!! route('sistema.acciones') !!}" ><span class="title">Acciones</span></a></li>
                <li @if(Request::segment(1) == 'seguimiento') class="active expanded" @endif><a href="{!! route('sistema.seguimiento') !!}" ><span class="title">Seguimiento</span></a></li>
            </ul><!--end /submenu -->
        </li><!--end /menu-li -->
    @endif
<!-- END TABLES -->

    @if (Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 3 || Auth::user()->rol == 4 || Auth::user()->rol == 5  )

    <!-- BEGIN Materias primas-->
        <li class="gui-folder @if( Request::segment(1) == 'reportes' ) active expanded @endif">
            <a>
                <div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
                <span class="title">Reportes</span>
            </a>
            <!--start submenu-->
            <ul>
                <li @if(Request::segment(1) == 'reportes') class="active expanded" @endif><a href="{!! route('sistema.reportes') !!}" ><span class="title">Reportes</span></a></li>
            <!--<li @if(Request::segment(1) == 'mprima') class="active expanded" @endif><a href="{!! route('sistema.mprima') !!}" ><span class="title">Detalle Materia prima</span></a></li>
								<li @if(Request::segment(1) == 'permisologia') class="active expanded" @endif><a href="{!! route('sistema.permisologia') !!}" ><span class="title">Detalle Permisología</span></a></li>-->
            </ul><!--end /submenu -->
        </li><!--end /menu-li-->
        <!-- END TABLES -->
    @endif


<!-- BEGIN Visitas -->
    @if (Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 4 )
        <li class="gui-folder @if( Request::segment(1) == 'visitas' ) active expanded @endif">
            <a>
                <div class="gui-icon"><i class="fa fa-car"></i></div>
                <span class="title">Visitas</span>
            </a>
            <!--start submenu -->
            <ul>
                <li @if(Request::segment(1) == 'visitas') class="active expanded" @endif><a href="{!! route('sistema.visitas') !!}" ><span class="title">Visitas</span></a></li>
           </ul><!--end /submenu -->
        </li><!--end /menu-li -->
        <!-- END TABLES -->
    @endif





<!-- BEGIN USUARIOS -->
    @if (Auth::user()->rol == 10 || Auth::user()->rol == 1 )
        <li class="gui-folder @if( Request::segment(1) == 'usuarios' || Request::segment(1) == 'logs') active expanded @endif">
            <a>
                <div class="gui-icon"><i class="fa fa-cogs"></i></div>
                <span class="title">Configuración</span>
            </a>
            <!--start submenu -->
            <ul>
                @if (Auth::user()->rol == 10 || Auth::user()->rol == 1 )
                    <li @if(Request::segment(1) == 'usuarios') class="active expanded" @endif><a href="{!! route('sistema.usuarios') !!}" ><span class="title">Usuarios</span></a></li>
                @endif
                @if (Auth::user()->rol == 10)
                    <li @if(Request::segment(1) == 'logs') class="active expanded" @endif><a href="{!! route('sistema.logs') !!}" ><span class="title">Logs</span></a></li>
                @endif
            </ul><!--end /submenu -->
        </li><!--end /menu-li -->
        <!-- END TABLES -->
@endif
<!-- BEGIN DASHBOARD -->
    <li>
        <a href="javascript:void(0)" onclick="logout()" >
            <div class="gui-icon"><i class="glyphicon glyphicon-log-out"></i></div>
            <span class="title">Salir</span>
        </a>
    </li><!--end /menu-li -->
    <!-- END DASHBOARD -->


</ul><!--end .main-menu -->
<!-- END MAIN MENU -->