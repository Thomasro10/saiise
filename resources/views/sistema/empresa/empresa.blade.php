@extends('layouts.master')

@section('title')
    .:: Empresa ::.
@endsection

@section('styles')
  <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/DataTables/jquery.dataTables.css') }}" >
    <!--<link href="{{ URL::to('assets/js/libs/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/jquery-ui/jquery-ui-theme.css?1423393666') }}" />-->
   <link href="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/css/responsive.dataTables.css') }}" rel="stylesheet">
   <link href="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/css/responsive.bootstrap.css') }}" rel="stylesheet">
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
    Empresa
@endsection

@section('content')

    @if(Auth::user()->rol != 30 && Auth::user()->rol != 3 )
    <div class="row">
        <div class="col-lg-12">
            <button type="button" class="btn ink-reaction btn-floating-action btn-sm btn-primary pull-right" id="btnAddEmp" title="Agregar registro">
                <i class="fa fa-plus-square"></i>
            </button>
        </div>
    </div>
    @endif
        <!--<div class="row">
            <div class="col-lg-12">
                <h4>En este modulo se guarda la información base de la empresa</h4>
            </div>
        </div>-->

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dt_emp" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="sort-numeric">ID</th>
                        <th class="sort-alpha" width="25%">Empresa</th>
                        <th class="sort-alpha">RIF</th>
                        <th class="sort-alpha">Clasificación</th>
                        <th class="sort-alpha">Estado</th>

                        <th class="sort-alpha">Gran sector</th>
                        <th class="sort-alpha">Rubro principal</th>
                        <th class="sort-alpha">Convenio (firma)</th>

                        <th class="sort-alfha">Municipio</th>
                        <th class="sort-alpha">Parroquia</th>
                        <th class="sort-alpha">Dirección</th>
                        <th class="sort-alpha">Contacto</th>
                        <th class="sort-alpha">CI</th>
                        <th class="sort-alpha">Cargo</th>
                        <th class="sort-alpha">Teléfono</th>
                        <th class="sort-alpha">Email</th>
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
                        <input type="hidden" id='id_emp_rif' name="id_emp_rif">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Actualizar Empresa</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="empresa2" name="empresa" required>
                                            <label for="empresa2">Empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="rif2" name="rif" required data-inputmask="'mask': 'R-99999999-9'">
                                            <label for="rif2">RIF</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="clasificacion2" name="clasificacion" class="form-control" >
                                                <option value="">&nbsp;</option>
                                                <option value="MICRO">MICRO</option>
                                                <option value="PEQUENA">PEQUENA</option>
                                                <option value="MEDIANA">MEDIANA</option>
                                                <option value="GRANDE">GRANDE</option>

                                            </select>
                                            <label for="clasificacion2">Clasificación</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="sector2" name="sector" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="AGROINDUSTRIAL">AGROINDUSTRIAL</option>
<option value="AUTOMOTRIZ">AUTOMOTRIZ</option>
<option value="CAPTACIÓN, TRATAMIENTO Y SUMINISTRO DE AGUA Y DESECHOS">CAPTACIÓN, TRATAMIENTO Y SUMINISTRO DE AGUA Y DESECHOS</option>
<option value="CAUCHO Y PLÁSTICO">CAUCHO Y PLÁSTICO</option>
<option value="COMERCIO">COMERCIO</option>
<option value="CONSTRUCCIÓN E INFRAESTRUCTURA">CONSTRUCCIÓN E INFRAESTRUCTURA</option>
<option value="MADERA, PULPA, PAPEL Y CARTÓN">MADERA, PULPA, PAPEL Y CARTÓN</option>
<option value="MAQUINARIA Y EQUIPO">MAQUINARIA Y EQUIPO</option>
<option value="MAQUINARIA Y EQUIPO DE TRANSPORTE">MAQUINARIA Y EQUIPO DE TRANSPORTE</option>
<option value="METALMECÁNICA, FERROSOS Y NO FERROSOS">METALMECÁNICA, FERROSOS Y NO FERROSOS</option>
<option value="MUEBLES">MUEBLES</option>
<option value="OTRAS INDUSTRIAS MANUFACTURERAS">OTRAS INDUSTRIAS MANUFACTURERAS</option>
<option value="PETRÓLEO, GAS Y MINERÍA">PETRÓLEO, GAS Y MINERÍA</option>
<option value="PRODUCCIÓN, TRANSMISIÓN Y DISTRIBUCIÓN DE ENERGÍA">PRODUCCIÓN, TRANSMISIÓN Y DISTRIBUCIÓN DE ENERGÍA</option>
<option value="QUÍMICO">QUÍMICO</option>
<option value="SALUD">SALUD</option>
<option value="SERVICIOS">SERVICIOS</option>
<option value="TECNOLOGÍA">TECNOLOGÍA</option>
<option value="TEXTIL, CUERO Y CALZADO">TEXTIL, CUERO Y CALZADO</option>
<option value="TRANSPORTE">TRANSPORTE</option>
<option value="TURISMO">TURISMO</option>
                                            </select>
                                            <label for="sector2">Gran sector</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="rubro2" name="rubro" required>
                                            <label for="rubro2">Rubro principal</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="convenio2" name="convenio" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="convenio2">Convenio (Firma)</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="edo2" name="edo" class="form-control"  onchange="getMcpiosPquias('edo2','mcpio2','{!! route('sistema.mcpios') !!}','pquia2')">
                                                <option value="">&nbsp;</option>
                                                @foreach ($edos as $edo)
                                                    <option value="{{ $edo->id }}">{{ $edo->nombre }}</option>
                                                @endforeach
                                            </select>
                                            <label for="edo2">Estado</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="mcpio2" name="mcpio" class="form-control" required  onchange="getMcpiosPquias('mcpio2','pquia2','{!! route('sistema.pquias') !!}')">
                                                <option value="">&nbsp;</option>
                                            </select>
                                            <label for="mcpio2">Municipio</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="pquia2" name="pquia" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                            </select>
                                            <label for="pquia2">Parroquia</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="direccion" id="direccion2" class="form-control" rows="2" placeholder="" ></textarea>
                                            <label for="direccion2">Dirección</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="contacto2" name="contacto" required>
                                            <label for="contacto2">Nombre y apellido del contacto</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" data-type="number" data-rule-digits="true" class="form-control" id="ci_cont2" name="ci_cont" >
                                            <label for="ci_cont2">Cédula</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cargo_cont2" name="cargo_cont" required>
                                            <label for="cargo_cont2">Cargo que ocupa en la empresa</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="telf2" name="telf" required data-inputmask="'mask': '9999-9999999'">
                                            <label for="telf2">Teléfono de contacto</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email2" name="email" >
                                            <label for="email2">Correo electrónico</label>
                                        </div>
                                    </div>
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
                                <header>Agregar empresa</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="empresa" name="empresa" required>
                                            <label for="empresa">Empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="rif" name="rif" required data-inputmask="'mask': 'R-99999999-9'">
                                            <label for="rif">RIF</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="clasificacion" name="clasificacion" class="form-control" >
                                                <option value="">&nbsp;</option>
                                                    <option value="MICRO">MICRO</option>
                                                    <option value="PEQUENA">PEQUENA</option>
                                                    <option value="MEDIANA">MEDIANA</option>
                                                    <option value="GRANDE">GRANDE</option>

                                            </select>
                                            <label for="clasificacion">Clasificación</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="sector" name="sector" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="AGROINDUSTRIAL">AGROINDUSTRIAL</option>
<option value="AUTOMOTRIZ">AUTOMOTRIZ</option>
<option value="CAPTACIÓN, TRATAMIENTO Y SUMINISTRO DE AGUA Y DESECHOS">CAPTACIÓN, TRATAMIENTO Y SUMINISTRO DE AGUA Y DESECHOS</option>
<option value="CAUCHO Y PLÁSTICO">CAUCHO Y PLÁSTICO</option>
<option value="COMERCIO">COMERCIO</option>
<option value="CONSTRUCCIÓN E INFRAESTRUCTURA">CONSTRUCCIÓN E INFRAESTRUCTURA</option>
<option value="MADERA, PULPA, PAPEL Y CARTÓN">MADERA, PULPA, PAPEL Y CARTÓN</option>
<option value="MAQUINARIA Y EQUIPO">MAQUINARIA Y EQUIPO</option>
<option value="MAQUINARIA Y EQUIPO DE TRANSPORTE">MAQUINARIA Y EQUIPO DE TRANSPORTE</option>
<option value="METALMECÁNICA, FERROSOS Y NO FERROSOS">METALMECÁNICA, FERROSOS Y NO FERROSOS</option>
<option value="MUEBLES">MUEBLES</option>
<option value="OTRAS INDUSTRIAS MANUFACTURERAS">OTRAS INDUSTRIAS MANUFACTURERAS</option>
<option value="PETRÓLEO, GAS Y MINERÍA">PETRÓLEO, GAS Y MINERÍA</option>
<option value="PRODUCCIÓN, TRANSMISIÓN Y DISTRIBUCIÓN DE ENERGÍA">PRODUCCIÓN, TRANSMISIÓN Y DISTRIBUCIÓN DE ENERGÍA</option>
<option value="QUÍMICO">QUÍMICO</option>
<option value="SALUD">SALUD</option>
<option value="SERVICIOS">SERVICIOS</option>
<option value="TECNOLOGÍA">TECNOLOGÍA</option>
<option value="TEXTIL, CUERO Y CALZADO">TEXTIL, CUERO Y CALZADO</option>
<option value="TRANSPORTE">TRANSPORTE</option>
<option value="TURISMO">TURISMO</option>
                                            </select>
                                            <label for="sector">Gran sector</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="rubro" name="rubro" required>
                                            <label for="rubro">Rubro principal</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="convenio" name="convenio" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="convenio">Convenio (Firma)</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="edo" name="edo" class="form-control" required onchange="getMcpiosPquias('edo','mcpio','{!! route('sistema.mcpios') !!}','pquia')">
                                                <option value="">&nbsp;</option>
                                                @foreach ($edos as $edo)
                                                    <option value="{{ $edo->id }}">{{ $edo->nombre }}</option>
                                                @endforeach
                                            </select>
                                            <label for="edo1">Estado</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="mcpio" name="mcpio" class="form-control" onchange="getMcpiosPquias('mcpio','pquia','{!! route('sistema.pquias') !!}')" required>
                                                <option value="">&nbsp;</option>
                                            </select>
                                            <label for="mcpio1">Municipio</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="pquia" name="pquia" class="form-control" required >
                                                <option value="">&nbsp;</option>
                                            </select>
                                            <label for="pquia1">Parroquia</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="direccion" id="direccion" class="form-control" rows="2" placeholder="" ></textarea>
                                            <label for="direccion">Dirección</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="contacto" name="contacto" required placeholder="Se recomienda que sea el director o presidente">
                                            <label for="contacto">Nombre y apellido del contacto</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" data-type="number" data-rule-digits="true" class="form-control" id="ci_cont" name="ci_cont" >
                                            <label for="ci_cont">Cédula</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cargo_cont" name="cargo_cont" required>
                                            <label for="cargo_cont">Cargo que ocupa en la empresa</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="telf" name="telf" required data-inputmask="'mask': '9999-9999999'">
                                            <label for="telf">Teléfono de contacto</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email" >
                                            <label for="email">Correo electrónico</label>
                                        </div>
                                    </div>
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

    <!-- BEGIN SIMPLE MODAL MARKUP -->
    <div class="modal fade" id="modalAsigResEmp" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form form-validate" role="form" id="asigEmpForm" novalidate >
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <input type="hidden" name="id_emp" id="id_emp_asig">
                <div class="modal-body">
                    <div class="card card-bordered style-primary">
                        <div class="card-head">
                            <div class="tools">
                                <div class="btn-group">
                                    <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                </div>
                            </div>
                            <header>Asignar responsable</header>
                        </div><!--end .card-head -->
                        <div class="card-body style-default-bright">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <select id="resp" name="resp" class="form-control" required>
                                            <option value="">&nbsp;</option>
                                            @foreach (\App\Http\Controllers\UtilidadesController::getResponsables() as $rp)
                                                <option value="{{ $rp->id }}">{{ $rp->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <label for="edo2">Responsable</label>
                                    </div>
                                </div>
                            </div>


                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAsigRes" class="btn ink-reaction btn-primary">Asignar</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END SIMPLE MODAL MARKUP -->

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

            $("input[data-type='number']").inputmask("decimal", {
                radixPoint: ",",
                autoGroup: true,
                groupSeparator: ".",
                groupSize: 3,
                autoUnmask: true
            });

            $(":input").inputmask();
            table = $('#dt_emp').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthMenu: [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "All"]],
                "order": [[ 0, "desc" ]],
               dom: 'Blfrtip',
                buttons: [
                    {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o"></i>',titleAttr: 'Excel', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs'},
                    {extend:'pdfHtml5',text:'<i class="fa fa-file-pdf-o"></i>',titleAttr: 'PDF', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs', orientation: 'landscape', pageSize: 'LEGAL'}
                ],
                language: {
                    url: '{{ URL::to('assets/js/libs/DataTables/spanish.json') }}'
                },
                ajax: {
                    url: '{!! route('sistema.empresas.data') !!}',
                    method: 'POST'
                },
                columns:
                [
                { data: 'id', name: 'empresas.id' },
                { data: 'empresa', name: 'empresas.empresa' },
                { data: 'rif', name: 'empresas.rif'  },
                { data: 'clasificacion', name: 'empresas.clasificacion'  },
                { data: 'estado', name: 'estados.nombre'  },

                { data: 'sector', name: 'empresas.sector', orderable: false, searchable: false, visible: false  },
                { data: 'rubro', name: 'empresas.rubro', orderable: false, searchable: false, visible: false  },
                { data: 'convenio', name: 'empresas.convenio', orderable: false, searchable: false, visible: false  },

                { data: 'municipio', name: 'municipios.nombre', orderable: false, searchable: false, visible: false  },
                { data: 'parroquia', name: 'parroquias.nombre', orderable: false, searchable: false, visible: false  },
                { data: 'direccion', name: 'empresas.direccion', orderable: false, searchable: false, visible: false  },
                { data: 'contacto', name: 'empresas.contacto'  },
                { data: 'ci_cont', name: 'empresas.ci_cont', orderable: false, searchable: false, visible: false  },
                { data: 'cargo_cont', name: 'empresas.cargo_cont', orderable: false, searchable: false, visible: false  },
                { data: 'telf', name: 'empresas.telf'  },
                { data: 'email', name: 'empresas.email', orderable: false, searchable: false, visible: false  },
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
            fAddEmp.validate();
            $('#btnAddOfic').click(function(){
                if(fAddEmp.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.empresas.add') !!}',
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
                    url:'{!! route('sistema.empresas.find') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {
                        $.each(data, function(i, item) {

                            $("#id_emp").val(item.id);
                            $("#id_emp_rif").val(item.rif);

                            $("#empresa2").val(item.empresa);
                            $("#rif2").val(item.rif);
                            $("#clasificacion2").append($('<option>').text(item.clasificacion).attr({value: item.clasificacion,selected: "selected"}));

                            $("#sector2").append($('<option>').text(item.sector).attr({value: item.sector,selected: "selected"}));
                            $("#rubro2").val(item.rubro);
                            $("#convenio2").append($('<option>').text(item.convenio).attr({value: item.convenio,selected: "selected"}));


                            $('#edo2').append($('<option>').text(item.estado).attr({value: item.edo,selected: "selected"}));
                            $('#mcpio2').append($('<option>').text(item.municipio).attr({value: item.mcpio,selected: "selected"}));
                            $('#pquia2').append($('<option>').text(item.parroquia).attr({value: item.pquia,selected: "selected"}));
                            $("#direccion2").val(item.direccion);

                            $("#contacto2").val(item.contacto);
                            $("#ci_cont2").val(item.ci_cont);
                            $("#cargo_cont2").val(item.cargo_cont);
                            $("#telf2").val(item.telf);
                            $("#email2").val(item.email);

                        })
                        $("#formActEmp").modal('show');
                    }
                });

            }

            var fActEmp = $("#actEmp");

            $('#formActEmp').on('hidden.bs.modal', function (e) {
                $('#edo2, #mcpio2, #pquia2').find('option:not(:first)').remove();
                $("#clasificacion2 option:last, #sector2 option:last, #convenio2 option:last").remove();
                fActEmp.clearForm();
            })

            fActEmp.validate();
            $('#btnActEmpr').click(function(){
                if(fActEmp.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.empresas.upd') !!}',
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
                        url:'{!! route('sistema.empresas.del') !!}',
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
                    url:'{!! route('sistema.empresas.view') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {

                        $("#divEmpDet").empty().html(data);
                        $("#detalleEmp").modal('show');

                    }
                });
            }

            asigResp = function (id) {
                $("#id_emp_asig").val(id);
                $("#modalAsigResEmp").modal('show');
            }

            var fAsigEmp = $("#asigEmpForm");
            fAsigEmp.validate();
            $('#btnAsigRes').click(function(){
                if(fAsigEmp.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.empresas.aresp') !!}',
                        data: fAsigEmp.serialize(),
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                fAsigEmp.clearForm();
                                $("#modalAsigResEmp").modal('hide');
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                }
            })



        });
    </script>
@endsection