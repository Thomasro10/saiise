@extends('layouts.master')

@section('title')
    .:: Inf. complementaria ::.
@endsection

@section('styles')
  <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/DataTables/jquery.dataTables.css') }}" >
    <!--<link href="{{ URL::to('assets/js/libs/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/jquery-ui/jquery-ui-theme.css?1423393666') }}" />-->
   <link href="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/css/responsive.dataTables.css') }}" rel="stylesheet">
   <link href="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/css/responsive.bootstrap.css') }}" rel="stylesheet">
   <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/wizard/wizard.css?1425466601') }}" >


  <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/fileuploader/uploadfile.css') }}" >
    <style>
        .ui-autocomplete {
            position: absolute;
            top: 0;
            left: 0;
            cursor: default;
            z-index: 9050 !important;
            max-height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        table{
            width: 100% !important;
        }


    </style>
@endsection

@section('section-header')
    Información complementaria
@endsection

@section('content')

    @if(Auth::user()->rol != 3  )
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="btn ink-reaction btn-floating-action btn-sm btn-primary pull-right" id="btnAddEmp" title="Agregar registro">
                    <i class="fa fa-plus-square"></i>
                </button>
            </div>
        </div>
    @endif
    @if(Auth::user()->rol == 30  )
       <!-- <div class="row">
            <div class="col-lg-12">
                <h4>En este modulo se guarda la información complementaria de la empresa</h4>
            </div>
        </div>-->
    @endif

    
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dt_emp" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="sort-alpha">Fecha</th>
                        <th class="sort-alpha">Empresa</th>
                        <th class="sort-alpha">RIF</th>
                        <th class="sort-alpha">Tipo de Empresa</th>
                        <th class="sort-alpha"># de Trabajadores</th>
                        <th class="sort-alpha">Actividad Económica</th>
                        <th class="sort-alpha">Si es otro, especifique</th>
                        <th class="sort-alpha">Capacidad Instalada</th>
                        <th class="sort-alpha">Unidad de Medida</th>
                        <th class="sort-alpha">Producción 2013</th>
                        <th class="sort-alpha">Producción 2014</th>
                        <th class="sort-alpha">Producción 2015</th>
                        <th class="sort-alpha">Producción 2016</th>
                        <th class="sort-alpha">Producción Actual</th>
                        <th class="sort-alpha">Capacidad Operativa</th>
                        <th class="sort-alpha">Motor al que Pertenece</th>
                        <th class="sort-alpha">Si es otro, especifique</th>
                        <th class="sort-alpha">Materia Prima</th>
                        <th class="sort-alpha">Descripción</th>
                        <th class="sort-alpha">Mercado a abastecer</th>
                        <th class="sort-alpha">Rubros</th>
                        <th class="sort-alpha">Obstaculos</th>
                        <th class="sort-alpha">&nbsp;</th>
                    </tr>
                    </thead>
                </table>
            </div><!--end .table-responsive -->
        </div><!--end .col -->
    </div><!--end .row -->


    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="formActEmp" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form-validate" role="form" id="actEmp" novalidate >
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <input type="hidden" id='id_emp' name="id">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Actualizar información complementaria</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="fecha2" name="fecha" required >
                                            <label for="fecha2">Fecha</label>
                                        </div>
                                    </div>
                                    @if(Auth::user()->rol == 30 )
                                        <input type="hidden" id="rif_emp2" name="rif_emp">
                                    @else
                                        <input type="hidden" name="rif_emp" id="rif_emp2">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="empresa2" name="empresa"  onfocus="getEmpresa('empresa2', 'rif_emp2', '{!! route('sistema.getEmpresa') !!}')" required>
                                                <label for="empresa2">Empresa teclee 2 letras para comensar la busqueda (Nombre o RIF (Ej. J-00000000-0))</label>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select id="tempresa2" name="tempresa" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="PÚBLICA">PÚBLICA</option>
                                                <option value="PRIVADA">PRIVADA</option>
                                                <option value="MIXTA">MIXTA</option>
                                                <option value="COOPERATIVA">COOPERATIVA</option>
                                                <option value="NUEVO EMPRENDEDOR">NUEVO EMPRENDEDOR</option>
                                            </select>
                                            <label for="tempresa2">Tipo de empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select id="ntrabajadores2" name="ntrabajadores" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="ENTRE 1 Y 5">ENTRE 1 Y 5</option>
                                                <option value="ENTRE 6 Y 15">ENTRE 6 Y 15</option>
                                                <option value="ENTRE 16 Y 30">ENTRE 16 Y 30</option>
                                                <option value="ENTRE 31 Y 50">ENTRE 31 Y 50</option>
                                                <option value="ENTRE 51 Y 100">ENTRE 51 Y 100</option>
                                                <option value="ENTRE 101 Y 200">ENTRE 101 Y 200</option>
                                                <option value="MÁS DE 200">MÁS DE 200</option>
                                            </select>
                                            <label for="ntrabajadores2">Nº de trabajadores</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select id="acteconomica2" name="acteconomica" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="METALMECANICA, FERROSOS Y NO FERROSOS">METALMECANICA, FERROSOS Y NO FERROSOS</option>
                                                <option value="AGROINDUSTRIAL">AGROINDUSTRIAL</option>
                                                <option value="SERVICIOS">SERVICIOS</option>
                                                <option value="TEXTIL CUERO Y CALZADO">TEXTIL CUERO Y CALZADO</option>
                                                <option value="MANUFACTURAS DIVERSAS">MANUFACTURAS DIVERSAS</option>
                                                <option value="PULPA, PAPEL, CARTON Y MADERA">PULPA, PAPEL, CARTON Y MADERA</option>
                                                <option value="QUIMICOS">QUIMICOS</option>
                                                <option value="PLASTICO">PLASTICO</option>
                                                <option value="SALUD">SALUD</option>
                                                <option value="CONSTRUCCION">CONSTRUCCION</option>
                                                <option value="COMERCIO">COMERCIO</option>
                                                <option value="AUTOMOTRIZ">AUTOMOTRIZ</option>
                                                <option value="RECICLAMIENTO">RECICLAMIENTO</option>
                                                <option value="PETROLEO Y MINERIA">PETROLEO Y MINERIA</option>
                                                <option value="OTROS">OTROS</option>
                                            </select>
                                            <label for="acteconomica2">Actividad económica</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="aeespec2" name="aeespec">
                                            <label for="aeespec2">Si es otro, especifique</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="capinstalada2" name="capinstalada" required>
                                            <label for="capinstalada2">Capacidad instalada</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="medida2" name="medida" required >
                                            <label for="medida2">Unidad de medida</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="pdc20132" name="pdc2013" required >
                                            <label for="pdc20132">Producción 2013</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="pdc20142" name="pdc2014" required >
                                            <label for="pdc20142">Producción 2014</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="pdc20152" name="pdc2015" required >
                                            <label for="pdc20152">Producción 2015</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="pdc20162" name="pdc2016" required >
                                            <label for="pdc20132">Producción 2016</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="pdcactual2" name="pdcactual" required >
                                            <label for="pdcactual2">Producción actual</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <select id="capoperativa2" name="capoperativa" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="0% A 20%">0% A 20%</option>
                                                <option value="20% a 40%">20% a 40%</option>
                                                <option value="40% A 60%">40% A 60%</option>
                                                <option value="60% A 80%">60% A 80%</option>
                                                <option value="80% A 100%">80% A 100%</option>
                                            </select>
                                            <label for="capoperativa2">Capacidad operativa</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select id="motor2" name="motor" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="AGROALIMENTARIO">AGROALIMENTARIO</option>
                                                <option value="FARMACÉUTICO">FARMACÉUTICO</option>
                                                <option value="INDUSTRIAL">INDUSTRIAL</option>
                                                <option value="NUEVAS EXPORTACIONES PARA GENERACIÓN DE DIVISAS">NUEVAS EXPORTACIONES PARA GENERACIÓN DE DIVISAS</option>
                                                <option value="ECONOMÍA COMUNAL, SOCIAL Y SOCIALISTA">ECONOMÍA COMUNAL, SOCIAL Y SOCIALISTA</option>
                                                <option value="HIDROCARBUROS">HIDROCARBUROS</option>
                                                <option value="PETROQUÍMICA">PETROQUÍMICA</option>
                                                <option value="MINERÍA">MINERÍA</option>
                                                <option value="TURISMO NACIONAL E INTERNACIONAL">TURISMO NACIONAL E INTERNACIONAL</option>
                                                <option value="CONSTRUCCIÓN">CONSTRUCCIÓN</option>
                                                <option value="FORESTAL">FORESTAL</option>
                                                <option value="MILITAR INDUSTRIAL">INDUSTRIA MILITAR</option>
                                                <option value="TELECOMUNICACIONES E INFORMÁTICA">TELECOMUNICACIONES E INFORMÁTICA</option>
                                                <option value="BANCA PÚBLICA Y PRIVADA">BANCA PÚBLICA Y PRIVADA</option>
                                                <option value="INDUSTRIAS BASICAS, ESTRATEGICAS Y SOCIALISTAS">INDUSTRIAS BASICAS, ESTRATEGICAS Y SOCIALISTAS</option>
                                            </select>
                                            <label for="motor2">Motor al que pertenece</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="motorespc2" name="motorespc" >
                                            <label for="motorespc2">Si es otro, especifique</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select id="mprima2" name="mprima" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="NACIONAL">NACIONAL</option>
                                                <option value="IMPORTADA">IMPORTADA</option>
                                                <option value="AMBAS">AMBAS</option>
                                            </select>
                                            <label for="mprima2">Materia prima</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="descripcion2" name="descripcion">
                                            <label for="descripcion2">Describir</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="mercabast2" name="mercabast" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="INTERNO">INTERNO</option>
                                                <option value="EXTERNO">EXTERNO</option>
                                                <option value="AMBOS">AMBOS</option>
                                            </select>
                                            <label for="mercabast2">Mercado a abastecer</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="rubros2" name="rubros" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="TEXTIL">TEXTIL</option>
                                                <option value="HIGIENE PERSONAL Y ASEO DEL HOGAR">HIGIENE PERSONAL Y ASEO DEL HOGAR</option>
                                                <option value="CALZADO Y CUERO">CALZADO Y CUERO</option>
                                                <option value="ALIMENTOS">ALIMENTOS</option>
                                                <option value="AUTOMOTRIZ">AUTOMOTRIZ</option>
                                                <option value="AGROPECUARIO">AGROPECUARIO</option>
                                                <option value="MATERIALES DE CONSTRUCCIÓN">MATERIALES DE CONSTRUCCIÓN</option>
                                                <option value="FARMACÉUTICO">FARMACÉUTICO</option>
                                                <option value="OTRO">OTRO</option>
                                            </select>
                                            <label for="rubros2">Rubro o producto principal</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="rubros">Nudos críticos</label>
                                            <div id="row">
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c12" name="obstaculos[]" type="checkbox" value="PERMISOLOGÍA"><span>PERMISOLOGÍA</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c22" name="obstaculos[]" type="checkbox" value="TRÁMITES"><span>TRÁMITES</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c32" name="obstaculos[]" type="checkbox" value="LOGÍSTICO"><span>LOGÍSTICO</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="row">
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c42" name="obstaculos[]" type="checkbox" value="ACCEDER A DIVISAS"><span>ACCEDER A DIVISAS</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c52" name="obstaculos[]" type="checkbox" value="ACCEDER A FINANCIAMIENTO"><span>ACCEDER A FINANCIAMIENTO</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c62" name="obstaculos[]" type="checkbox" value="ACCEDER A MATERIAS PRIMAS"><span>ACCEDER A MATERIAS PRIMAS</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="row">
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c72" name="obstaculos[]" type="checkbox" value="ACCEDER A INSUMOS O REPUESTOS"><span>ACCEDER A INSUMOS O REPUESTOS</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c82" name="obstaculos[]" type="checkbox" value="ASPECTOS LABORALES"><span>ASPECTOS LABORALES</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="otro2" name="obstaculos[]" >
                                                        <label for="otro2">Especifique</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end .form-group -->
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnActEmpr">Actualizar</button>
                                <!--<input type="submit" class="btn btn-primary" value="Guardar">-->
                            </div>
                        </div><!--end .card -->
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END FORM MODAL MARKUP -->
    <!-- BEGIN SIMPLE MODAL MARKUP -->
    <div class="modal fade" id="detalleEmp" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card card-bordered style-primary">
                        <div class="card-head">
                            <div class="tools">
                                <div class="btn-group">
                                    <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                </div>
                            </div>
                            <header>Detalle Empresa</header>
                        </div><!--end .card-head -->
                        <div class="card-body style-default-bright">
                            <div id="divEmpDet"></div>


                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn ink-reaction btn-primary" data-dismiss="modal">Aceptar</button>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END SIMPLE MODAL MARKUP -->
   

    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="formAddEmp" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form-validate" role="form" id="addEmp" novalidate >
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Agregar información complementaria</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="fecha" name="fecha" required value="{{ date('Y-m-d') }}">
                                            <label for="fecha">Fecha</label>
                                        </div>
                                    </div>
                                    @if(Auth::user()->rol == 30 )
                                        <input type="hidden" name="rif_emp" value="{{ Auth::user()->empresa }}">
                                    @else
                                        <input type="hidden" name="rif_emp" id="rif_emp">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="empresa" name="empresa"  onfocus="getEmpresa('empresa', 'rif_emp', '{!! route('sistema.getEmpresa') !!}')" required>
                                                <label for="empresa">Empresa teclee 2 letras para comensar la busqueda (Nombre o RIF (Ej. J-00000000-0))</label>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select id="tempresa" name="tempresa" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="PÚBLICA">PÚBLICA</option>
                                                <option value="PRIVADA">PRIVADA</option>
                                                <option value="MIXTA">MIXTA</option>
                                                <option value="COOPERATIVA">COOPERATIVA</option>
                                                <option value="NUEVO EMPRENDEDOR">NUEVO EMPRENDEDOR</option>
                                            </select>
                                            <label for="tempresa">Tipo de empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select id="ntrabajadores" name="ntrabajadores" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="ENTRE 1 Y 5">ENTRE 1 Y 5</option>
                                                <option value="ENTRE 6 Y 15">ENTRE 6 Y 15</option>
                                                <option value="ENTRE 16 Y 30">ENTRE 16 Y 30</option>
                                                <option value="ENTRE 31 Y 50">ENTRE 31 Y 50</option>
                                                <option value="ENTRE 51 Y 100">ENTRE 51 Y 100</option>
                                                <option value="ENTRE 101 Y 200">ENTRE 101 Y 200</option>
                                                <option value="MÁS DE 200">MÁS DE 200</option>
                                            </select>
                                            <label for="ntrabajadores">Nº de trabajadores</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select id="acteconomica" name="acteconomica" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="METALMECANICA, FERROSOS Y NO FERROSOS">METALMECANICA, FERROSOS Y NO FERROSOS</option>
                                                <option value="AGROINDUSTRIAL">AGROINDUSTRIAL</option>
                                                <option value="SERVICIOS">SERVICIOS</option>
                                                <option value="TEXTIL CUERO Y CALZADO">TEXTIL CUERO Y CALZADO</option>
                                                <option value="MANUFACTURAS DIVERSAS">MANUFACTURAS DIVERSAS</option>
                                                <option value="PULPA, PAPEL, CARTON Y MADERA">PULPA, PAPEL, CARTON Y MADERA</option>
                                                <option value="QUIMICOS">QUIMICOS</option>
                                                <option value="PLASTICO">PLASTICO</option>
                                                <option value="SALUD">SALUD</option>
                                                <option value="CONSTRUCCION">CONSTRUCCION</option>
                                                <option value="COMERCIO">COMERCIO</option>
                                                <option value="AUTOMOTRIZ">AUTOMOTRIZ</option>
                                                <option value="RECICLAMIENTO">RECICLAMIENTO</option>
                                                <option value="PETROLEO Y MINERIA">PETROLEO Y MINERIA</option>
                                                <option value="OTROS">OTROS</option>
                                            </select>
                                            <label for="acteconomica">Actividad económica</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="aeespec" name="aeespec">
                                            <label for="aeespec">Si es otro, especifique</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="capinstalada" name="capinstalada" required>
                                            <label for="capinstalada">Capacidad instalada</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="medida" name="medida" required >
                                            <label for="medida">Unidad de medida</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="pdc2013" name="pdc2013" required >
                                            <label for="pdc2013">Producción 2013</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="pdc2014" name="pdc2014" required >
                                            <label for="pdc2014">Producción 2014</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="pdc2015" name="pdc2015" required >
                                            <label for="pdc2015">Producción 2015</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="pdc2016" name="pdc2016" required >
                                            <label for="pdc2013">Producción 2016</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="pdcactual" name="pdcactual" required >
                                            <label for="pdcactual">Producción actual</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <select id="capoperativa" name="capoperativa" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="0% A 20%">0% A 20%</option>
                                                <option value="20% a 40%">20% a 40%</option>
                                                <option value="40% A 60%">40% A 60%</option>
                                                <option value="60% A 80%">60% A 80%</option>
                                                <option value="80% A 100%">80% A 100%</option>
                                            </select>
                                            <label for="capoperativa">Capacidad operativa</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select id="motor" name="motor" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="AGROALIMENTARIO">AGROALIMENTARIO</option>
                                                <option value="FARMACÉUTICO">FARMACÉUTICO</option>
                                                <option value="INDUSTRIAL">INDUSTRIAL</option>
                                                <option value="NUEVAS EXPORTACIONES PARA GENERACIÓN DE DIVISAS">NUEVAS EXPORTACIONES PARA GENERACIÓN DE DIVISAS</option>
                                                <option value="ECONOMÍA COMUNAL, SOCIAL Y SOCIALISTA">ECONOMÍA COMUNAL, SOCIAL Y SOCIALISTA</option>
                                                <option value="HIDROCARBUROS">HIDROCARBUROS</option>
                                                <option value="PETROQUÍMICA">PETROQUÍMICA</option>
                                                <option value="MINERÍA">MINERÍA</option>
                                                <option value="TURISMO NACIONAL E INTERNACIONAL">TURISMO NACIONAL E INTERNACIONAL</option>
                                                <option value="CONSTRUCCIÓN">CONSTRUCCIÓN</option>
                                                <option value="FORESTAL">FORESTAL</option>
                                                <option value="MILITAR INDUSTRIAL">INDUSTRIA MILITAR</option>
                                                <option value="TELECOMUNICACIONES E INFORMÁTICA">TELECOMUNICACIONES E INFORMÁTICA</option>
                                                <option value="BANCA PÚBLICA Y PRIVADA">BANCA PÚBLICA Y PRIVADA</option>
                                                <option value="INDUSTRIAS BASICAS, ESTRATEGICAS Y SOCIALISTAS">INDUSTRIAS BASICAS, ESTRATEGICAS Y SOCIALISTAS</option>
                                            </select>
                                            <label for="motor">Motor al que pertenece</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="motorespc" name="motorespc" >
                                            <label for="motorespc">Si es otro, especifique</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select id="mprima" name="mprima" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="NACIONAL">NACIONAL</option>
                                                <option value="IMPORTADA">IMPORTADA</option>
                                                <option value="AMBAS">AMBAS</option>
                                            </select>
                                            <label for="mprima">Materia prima</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="descripcion" name="descripcion">
                                            <label for="descripcion">Describir</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="mercabast" name="mercabast" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="INTERNO">INTERNO</option>
                                                <option value="EXTERNO">EXTERNO</option>
                                                <option value="AMBOS">AMBOS</option>
                                            </select>
                                            <label for="mercabast">Mercado a abastecer</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="rubros" name="rubros" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="TEXTIL">TEXTIL</option>
                                                <option value="HIGIENE PERSONAL Y ASEO DEL HOGAR">HIGIENE PERSONAL Y ASEO DEL HOGAR</option>
                                                <option value="CALZADO Y CUERO">CALZADO Y CUERO</option>
                                                <option value="ALIMENTOS">ALIMENTOS</option>
                                                <option value="AUTOMOTRIZ">AUTOMOTRIZ</option>
                                                <option value="AGROPECUARIO">AGROPECUARIO</option>
                                                <option value="MATERIALES DE CONSTRUCCIÓN">MATERIALES DE CONSTRUCCIÓN</option>
                                                <option value="FARMACÉUTICO">FARMACÉUTICO</option>
                                                <option value="OTRO">OTRO</option>
                                            </select>
                                            <label for="rubros">Rubro o producto principal</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="rubros">Nudos críticos</label>
                                            <div id="row">
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c1" name="obstaculos[]" type="checkbox" value="PERMISOLOGÍA"><span>PERMISOLOGÍA</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c2" name="obstaculos[]" type="checkbox" value="TRÁMITES"><span>TRÁMITES</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c3" name="obstaculos[]" type="checkbox" value="LOGÍSTICO"><span>LOGÍSTICO</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="row">
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c4" name="obstaculos[]" type="checkbox" value="ACCEDER A DIVISAS"><span>ACCEDER A DIVISAS</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c5" name="obstaculos[]" type="checkbox" value="ACCEDER A FINANCIAMIENTO"><span>ACCEDER A FINANCIAMIENTO</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c6" name="obstaculos[]" type="checkbox" value="ACCEDER A MATERIAS PRIMAS"><span>ACCEDER A MATERIAS PRIMAS</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="row">
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c7" name="obstaculos[]" type="checkbox" value="ACCEDER A INSUMOS O REPUESTOS"><span>ACCEDER A INSUMOS O REPUESTOS</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="c8" name="obstaculos[]" type="checkbox" value="ASPECTOS LABORALES"><span>ASPECTOS LABORALES</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="otro" name="obstaculos[]" >
                                                        <label for="descripcion">Especifique</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end .form-group -->
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnAddOfic">Guardar</button>
                                <!--<input type="submit" class="btn btn-primary" value="Guardar">-->
                            </div>
                        </div><!--end .card -->
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END FORM MODAL MARKUP -->

@endsection

@section('scripts')

    <script src="{{ URL::to('assets/js/libs/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/js/dataTables.responsive.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/js/responsive.bootstrap.js') }}"></script>
    <!--<script src="{{ URL::to('assets/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-validation/dist/localization/messages_es.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="//maps.google.com/maps/api/js?libraries=drawing&key=AIzaSyBZ6ooejXK15F5o-1J-PLjf7EZUG4OliKY"></script>
    <script src="{{ URL::to('assets/js/libs/gmaps/gmaps.js') }}"></script>-->
    <script src="{{ URL::to('assets/js/libs/fileuploader/jquery.uploadfile.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/core/demo/DemoFormWizard.js') }}"></script>





    <script>
        $.extend($.inputmask.defaults.definitions, {
            'R': {  //masksymbol
                "validator": "[vVeEjJgG]",
                "cardinality": 1,
                'prevalidator': null
            }
        });

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ Session::token() }}'
                }
            });

            $(":input").inputmask();
            table = $('#dt_emp').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthMenu: [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "All"]],
                //"order": [[ 0, "desc" ]],
               dom: 'Blfrtip',
                buttons: [
                    {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o"></i>',titleAttr: 'Excel', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs'},
                    {extend:'pdfHtml5',text:'<i class="fa fa-file-pdf-o"></i>',titleAttr: 'PDF', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs', orientation: 'landscape', pageSize: 'LEGAL'}
                ],
                language: {
                    url: '{{ URL::to('assets/js/libs/DataTables/spanish.json') }}'
                },
                ajax: {
                    url: '{!! route('sistema.encuestas.data') !!}',
                    method: 'POST'
                },
                columns:
                [
                { data: 'fecha', name: 'fecha'  },
                { data: 'empresa', name: 'empresas.empresa' },
                { data: 'rif', name: 'eempresas.rif'  },
                { data: 'tempresa', name: 'encuestas.tempresa'  },
                { data: 'ntrabajadores', name: 'encuestas.ntrabajadores', orderable: false, searchable: false, visible: false  },
                { data: 'acteconomica', name: 'encuestas.acteconomica' },
                { data: 'aeespec', name: 'encuestas.aeespec', orderable: false, searchable: false, visible: false  },
                { data: 'capinstalada', name: 'encuestas.capinstalada', orderable: false, searchable: false, visible: false  },
                { data: 'medida', name: 'encuestas.medida', orderable: false, searchable: false, visible: false  },
                { data: 'pdc2013', name: 'encuestas.pdc2013', orderable: false, searchable: false, visible: false  },
                { data: 'pdc2014', name: 'encuestas.pdc2014', orderable: false, searchable: false, visible: false  },
                { data: 'pdc2015', name: 'encuestas.pdc2015', orderable: false, searchable: false, visible: false  },
                { data: 'pdc2016', name: 'encuestas.pdc2016', orderable: false, searchable: false, visible: false  },
                { data: 'pdcactual', name: 'encuestas.pdcactual', orderable: false, searchable: false, visible: false  },
                { data: 'capoperativa', name: 'encuestas.capoperativa', orderable: false, searchable: false, visible: false  },
                { data: 'motor', name: 'encuestas.motor'  },
                { data: 'motorespc', name: 'encuestas.motorespc', orderable: false, searchable: false, visible: false  },
                { data: 'mprima', name: 'encuestas.mprima', orderable: false, searchable: false, visible: false  },
                { data: 'descripcion', name: 'encuestas.descripcion', orderable: false, searchable: false, visible: false  },
                { data: 'mercabast', name: 'encuestas.mercabast'  },
                { data: 'rubros', name: 'encuestas.rubros', orderable: false, searchable: false, visible: false  },
                { data: 'obstaculos', name: 'encuestas.obstaculos', orderable: false, searchable: false, visible: false  },
                { data: 'accion', name: 'accion', orderable: false, searchable: false }
                ]
            });

            getMcpiosPquias = function(el1, el2, urls, el3){
                if($('#'+el1).val()!=''){

                    $.ajax({
                        dataType: "json",
                        url: urls,
                        data: { edo: $('#'+el1).val(), mcpio : $('#'+el1).val(), rand: Math.random() },
                        beforeSend: function() { $('#'+el2).addClass('ui-autocomplete-loading'); },
                        success: function(data) {
                            $('#'+el2).find('option:not(:first)').remove().removeClass('ui-autocomplete-loading');
                            $.each(data, function(i, item) {
                                $('#'+el2).append($('<option>').text(item.label).attr('value', item.value));
                            });
                        },
                        complete:function(){ $('#'+el2).removeClass('ui-autocomplete-loading'); }
                    });
                }
                else{
                    if(el3){
                        $('#'+el2+',#'+el3).find('option:not(:first)').remove();
                    }
                    else{
                        $('#'+el2).find('option:not(:first)').remove();
                    }

                }
            }

            $("#btnAddEmp").click(function(){
                $("#formAddEmp").clearForm();
                $("#formAddEmp").modal('show');
            })

            var fAddEmp = $("#addEmp");
            fAddEmp.validate({
                ignore: ""
            });
            $('#btnAddOfic').click(function(){
                if(fAddEmp.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.encuestas.add') !!}',
                        data: fAddEmp.serialize(),
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                table.ajax.reload( null, false );
                                fAddEmp.clearForm();
                                $("#formAddEmp").modal('hide');
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                }
            })

            findUpdateEnc  = function(id){
                $.ajax({
                    type: "POST",
                    url:'{!! route('sistema.encuestas.find') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {
                        $.each(data, function(i, item) {

                            $("#id_emp").val(item.id);
                            $("#fecha2").val(item.fecha);
                            $("#empresa2").val(item.empresa);
                            $("#rif_emp2").val(item.rif);

                            $("#tempresa2").append($('<option>').text(item.tempresa).attr({value: item.tempresa,selected: "selected"}));
                            $("#ntrabajadores2").append($('<option>').text(item.ntrabajadores).attr({value: item.ntrabajadores,selected: "selected"}));
                            $("#acteconomica2").append($('<option>').text(item.acteconomica).attr({value: item.acteconomica,selected: "selected"}));
                            $("#aeespec2").val(item.aeespec);
                            $("#capinstalada2").val(item.capinstalada);
                            $("#medida2").val(item.medida);
                            $("#pdc20132").val(item.pdc2013);
                            $("#pdc20142").val(item.pdc2014);
                            $("#pdc20152").val(item.pdc2015);
                            $("#pdc20162").val(item.pdc2016);
                            $("#pdcactual2").val(item.pdcactual);
                            $("#capoperativa2").append($('<option>').text(item.capoperativa).attr({value: item.capoperativa,selected: "selected"}));
                            $("#motor2").append($('<option>').text(item.motor).attr({value: item.motor,selected: "selected"}));
                            $("#motorespc2").val(item.motorespc);
                            $("#mprima2").append($('<option>').text(item.mprima).attr({value: item.mprima,selected: "selected"}));
                            $("#descripcion2").val(item.descripcion);
                            $("#mercabast2").append($('<option>').text(item.mercabast).attr({value: item.mercabast,selected: "selected"}));
                            $("#rubros2").append($('<option>').text(item.rubros).attr({value: item.rubros,selected: "selected"}));

                            obs = item.obstaculos.split(',')
                            for(i = 0; i < obs.length; i++){
                                switch(obs[i]){
                                    case 'PERMISOLOGÍA':
                                        $('#c12').prop('checked', true);
                                    break;
                                    case 'TRÁMITES':
                                        $('#c22').prop('checked', true);
                                    break;
                                    case 'LOGÍSTICO':
                                        $('#c32').prop('checked', true);
                                    break;
                                    case 'ACCEDER A DIVISAS':
                                        $('#c42').prop('checked', true);
                                    break;
                                    case 'ACCEDER A FINANCIAMIENTO':
                                        $('#c52').prop('checked', true);
                                    break;
                                    case 'ACCEDER A MATERIAS PRIMAS':
                                        $('#c62').prop('checked', true);
                                    break;
                                    case 'ACCEDER A INSUMOS O REPUESTOS':
                                        $('#c72').prop('checked', true);
                                    break;
                                    case 'ASPECTOS LABORALES':
                                        $('#c82').prop('checked', true);
                                    break;
                                    default:
                                        $("#otro2").val(obs[i]);
                                    break;

                                }
                            }
                        })
                        $("#formActEmp").modal('show');
                    }
                });

            }

            var fActEmp = $("#actEmp");

            $('#formActEmp').on('hidden.bs.modal', function (e) {
                $('#edo2, #mcpio2, #pquia2').find('option:not(:first)').remove();
                $("#tempresa2 option:last, #ntrabajadores2 option:last, #acteconomica2 option:last, #capoperativa2 option:last, #motor2 option:last, #mprima2 option:last, #mercabast2 option:last, #rubros2 option:last").remove();
                fActEmp.clearForm();
            })

            fActEmp.validate();
            $('#btnActEmpr').click(function(){
                if(fActEmp.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.encuestas.upd') !!}',
                        data: fActEmp.serialize(),
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                table.ajax.reload( null, false );
                                fActEmp.clearForm();
                                $("#formActEmp").modal('hide');
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                }
            })

            deleteEnc = function(id){

                swal({
                    title: "¿Esta seguro que quiere borrar este registro?",
                    text: "Esta acción no puede ser desecha",
                    type: "warning",
                    cancelButtonText: "No",
                    showCancelButton: true,
                    confirmButtonText: "Si, estoy seguro",
                    reverseButtons: true
                }).then(function (text) {
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.encuestas.del') !!}',
                        data: {"_token": "{{ csrf_token() }}", "id": id},
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                table.ajax.reload( null, false );
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                });

            }

            viewEnc = function(id){
                $("#detalleEmp").modal('show');

                $.ajax({
                    type: "POST",
                    url:'{!! route('sistema.encuestas.view') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {

                        $("#divEmpDet").empty().html(data);
                        $("#detalleEmp").modal('show');
                        /*  $.each(data, function(i, item) {


                          html = '<div class="row">' +
                                    '<div class="col-sm-4">Fecha de registro: <b>'+item.fecha+'</b></div>' +
                                    '<div class="col-sm-4">Anfitrión: <b>'+item.nanfi+'</b></div>' +
                                    '<div class="col-sm-4">CI: <b>'+item.cianf+'</b></div>' +
                                    '</div>';
                            html += '<div class="row">' +
                                    '<div class="col-sm-4">Atendido: <b>'+item.naten+'</b></div>' +
                                    '<div class="col-sm-4">CI: <b>'+item.ciaten+'</b></div>' +
                                    '<div class="col-sm-4">Cargo: <b>'+item.cargoaten+'</b></div>' +
                                    '</div>';
                            html += '<div class="row">' +
                                    '<div class="col-sm-3">Empresa: <b>'+item.empresa+'</b></div>' +
                                    '<div class="col-sm-3">RIF: <b>'+item.rif+'</b></div>' +
                                    '<div class="col-sm-3">Telf.: <b>'+item.telf+'</b></div>' +
                                    '<div class="col-sm-3">Email: <b>'+item.email+'</b></div>' +
                                    '</div>';
                            html += '<div class="row">' +
                                    '<div class="col-sm-4">Estado: <b>'+item.estado+'</b></div>' +
                                    '<div class="col-sm-4">Municipio: <b>'+item.municipio+'</b></div>' +
                                    '<div class="col-sm-4">Parroquia: <b>'+item.parroquia+'</b></div>' +
                                    '</div>';
                            html += '<div class="row">' +
                                    '<div class="col-sm-12">Dirección: <b>'+item.direccion+'</b></div>' +
                                    '</div>';
                            html += '<div class="row">' +
                                    '<div class="col-sm-3">Tipo de empresa: <b>'+item.tempresa+'</b></div>' +
                                    '<div class="col-sm-3">Nº de trabajadores: <b>'+item.ntrabajadores+'</b></div>' +
                                    '<div class="col-sm-3">Actividad económica: <b>'+item.acteconomica+'</b></div>' +
                                    '<div class="col-sm-3">Si es otra, especifique: <b>'+item.aeespec+'</b></div>' +
                                    '</div>';
                            html += '<div class="row">' +
                                    '<div class="col-sm-6">Capacidad Instalada: <b>'+item.capinstalada+'</b></div>' +
                                    '<div class="col-sm-6">Unidad de medida: <b>'+item.medida+'</b></div>' +
                                    '</div>';
                            html += '<div class="row">' +
                                    '<div class="col-sm-2">Prod. 2013: <b>'+item.pdc2013+'</b></div>' +
                                    '<div class="col-sm-2">Prod. 2014: <b>'+item.pdc2014+'</b></div>' +
                                    '<div class="col-sm-2">Prod. 2015: <b>'+item.pdc2015+'</b></div>' +
                                    '<div class="col-sm-2">Prod. 2016: <b>'+item.pdc2016+'</b></div>' +
                                    '<div class="col-sm-2">Prod. Actual: <b>'+item.pdcactual+'</b></div>' +
                                    '<div class="col-sm-2">Cap. Operativa: <b>'+item.capoperativa+'</b></div>' +
                                    '</div>';
                            html += '<div class="row">' +
                                    '<div class="col-sm-3">Motor: <b>'+item.motor+'</b></div>' +
                                    '<div class="col-sm-3">Si es otro, especifique: <b>'+item.motorespc+'</b></div>' +
                                    '<div class="col-sm-3">Materia Prima: <b>'+item.mprima+'</b></div>' +
                                    '<div class="col-sm-3">Descripción: <b>'+item.descripcion+'</b></div>' +
                                    '</div>';
                            html += '<div class="row">' +
                                    '<div class="col-sm-6">Mercado a abastecer: <b>'+item.mercabast+'</b></div>' +
                                    '<div class="col-sm-6">Principal rubro: <b>'+item.rubros+'</b></div>' +
                                    '</div>';
                            html += '<div class="row">' +
                                    '<div class="col-sm-12">Obstaculos: <b>'+item.obstaculos+'</b></div>' +
                                    '</div>';
                          alert(item.html)

                            $("#divEmpDet").empty().html(item.html);
                            $("#detalleEmp").modal('show');
                        })*/
                    }
                });
            }

        });
    </script>
@endsection