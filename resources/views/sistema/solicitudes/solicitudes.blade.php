@extends('layouts.master')

@section('title')
    .:: Requerimientos/Solicitudes ::.
@endsection

@section('styles')
  <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/DataTables/jquery.dataTables.css') }}" />
    <!--<link href="{{ URL::to('assets/js/libs/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">-->
   <link href="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/css/responsive.dataTables.css') }}" rel="stylesheet">
   <link href="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/css/responsive.bootstrap.css') }}" rel="stylesheet">
    <!--<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/jquery-ui/jquery-ui-theme.css?1423393666') }}" />-->
    <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/fileuploader/uploadfile.css') }}" />
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
    Requerimientos/Solicitudes
@endsection

@section('content')
    @if( Auth::user()->rol != 3 )
    <div class="row">
        <div class="col-lg-12">
            <button type="button" class="btn ink-reaction btn-floating-action btn-sm btn-primary pull-right" id="btnAddEmp" title="Agregar registro">
                <i class="fa fa-plus-square"></i>
            </button>
        </div>
    </div>
    @endif
    @if(Auth::user()->rol == 30 )
        <!--<div class="row">
            <div class="col-lg-12">
                <h4>En este módulo se guarda la información que tiene que ver con la materia prima utilizada</h4>
                <h4>Para asociar la empresa debe seleccionar la misma en el campo empresa del formulario, una vez se halla realizado la busqueda en el mismo por RIF O NOMBRE</h4>
            </div>
        </div>-->
    @endif


    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dt_emp" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="sort-numeric">ID</th>
                        <th class="sort-alpha">Fecha</th>
                        <th class="sort-alpha">Empresa</th>
                        <th class="sort-alpha">Origen solicitud</th>
                        <th class="sort-alpha">Especifique</th>
                        <th class="sort-alpha">Objeto solicitud</th>
                        <th class="sort-alpha">Objeto proyecto</th>
                        <th class="sort-alpha">Tiene proyecto</th>
                        <th class="sort-numeric">Monto Bs</th>
                        <th class="sort-numeric">Monto USD</th>
                        <th class="sort-alpha">Para</th>
                        <th class="sort-alpha">Banco de preferencia</th>
                        <th class="sort-alpha">Otro objeto solicitud</th>
                        <th class="sort-alpha">Observación</th>
                        <th class="sort-alpha" width="15%">&nbsp;</th>
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
                        <input type="hidden" name="id" id="id_mp">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Actualizar Solicitud</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="fecha2" name="fecha" >
                                            <label for="fecha2">Fecha</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="origen2" name="origen" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="MINISTRO (MPPEF)">MINISTRO (MPPEF)</option>
                                                <option value="CONSEJO NACIONAL DE ECONOMÍA PRODUCTIVA (CNEP)">CONSEJO NACIONAL DE ECONOMÍA PRODUCTIVA (CNEP)</option>
                                                <option value="VICEMINISTROS (MPPEF)">VICEMINISTROS (MPPEF)</option>
                                                <option value="FERIAS O EXPOSICIONES">FERIAS O EXPOSICIONES</option>
                                                <option value="OTROS">OTROS</option>
                                            </select>
                                            <label for="origen2">Origen de la solicitud</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="ori_especifique2" name="ori_especifique" required onfocus="getMPrimaMedida('ori_especifique2', '{!! route('sistema.getFeriaEsp') !!}')">
                                            <label for="ori_especifique2">Especifique</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <select id="objeto2" name="objeto" class="form-control objeto" required>
                                                <option value="">&nbsp;</option>
                                                @if(Auth::user()->rol == 40)
                                                <option value="PRESENTACIÓN DE PROYECTO">PRESENTACIÓN DE PROYECTO</option>
                                                @else
                                                <option value="PRESENTACIÓN DE PROYECTO">PRESENTACIÓN DE PROYECTO</option>
                                                <option value="FINANCIAMIENTO">FINANCIAMIENTO</option>
                                                <option value="MATERIA PRIMA">MATERIA PRIMA</option>
                                                <option value="PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS">PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS</option>
                                                <option value="OTROS">OTROS</option>
                                                @endif
                                            </select>
                                            <label for="objeto2">Objeto de la solicitud</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="proyecto2" style="display: none">
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="obj_proyecto2" name="obj_proyecto">
                                            <label for="obj_proyecto2">Descripción del proyecto (Objeto)</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                            <div class="form-group">
                                                <select id="tproy2" name="tproy" class="form-control" required>
                                                    <option value="">&nbsp;</option>
                                                    <option value="SI">SI</option>
                                                    <option value="NO">NO</option>
                                                </select>
                                                <label for="tproy2">Tiene Proyecto</label>
                                            </div>
                                    </div>
                                </div>
                                <!--   -->

                                <div id="finanzas2" style="display: none">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text" data-type="number" placeholder="Para colocar decimales utilizar coma (,)" class="form-control" id="fin_montobs2" name="fin_montobs">
                                                <label for="fin_montobs2">Monto requerido en bolívares</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text" data-type="number" placeholder="Para colocar decimales utilizar coma (,)" class="form-control" id="fin_montousd2" name="fin_montousd">
                                                <label for="fin_montousd2">Monto requerido en dolares</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="rubros">Para:</label>
                                                <div id="row">
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="c12" name="fin_para[]" type="checkbox" value="MATERIA PRIMA"><span>MATERIA PRIMA</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="c22" name="fin_para[]" type="checkbox" value="INSUMOS O MAQUINARIA Y EQUIPOS"><span>INSUMOS O MAQUINARIA Y EQUIPOS</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="c32" name="fin_para[]" type="checkbox" value="AMPLIACION DE CAPACIDAD INSTALADA"><span>AMPLIACION DE CAPACIDAD INSTALADA</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="row">
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="c42" name="fin_para[]" type="checkbox" value="CAPITAL DE TRABAJO"><span>CAPITAL DE TRABAJO</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="c52" name="fin_para[]" type="checkbox" value="MANTENIMIENTO"><span>MANTENIMIENTO</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--end .form-group -->
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="fin_banco">Banco(s) de preferencia</label>
                                                <div id="row">
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="b12" name="fin_banco[]" type="checkbox" value="BANCO DE VENEZUELA"><span>BANCO DE VENEZUELA</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="b22" name="fin_banco[]" type="checkbox" value="BANCO DEL TESORO"><span>BANCO DEL TESORO</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="b32" name="fin_banco[]" type="checkbox" value="BANCO BICENTENARIO"><span>BANCO BICENTENARIO</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="row">

                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="b42" name="fin_banco[]" type="checkbox" value="BANCOEX"><span>BANCOEX</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="b52" name="fin_banco[]" type="checkbox" value="BANDES"><span>BANDES</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="b62" name="fin_banco[]" type="checkbox" value="BANCO AGRICOLA"><span>BANCO AGRICOLA</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="row">
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="b72" name="fin_banco[]" type="checkbox" value="BANFANB"><span>BANFANB</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="b92" name="fin_banco[]" type="checkbox" value="BANCO DE LA MUJER"><span>BANCO DE LA MUJER</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="b82" name="fin_banco[]" type="checkbox" value="FONDO GUBERNAMENTAL"><span>FONDO GUBERNAMENTAL</span>
                                                        </label>
                                                    </div>
                                                    <!--<div class="col-sm-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="ob" name="remitido_a[]" >
                                                            <label for="ob">Especifique</label>
                                                        </div>
                                                    </div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                </div>

                                <div class="row" id="otros_sol2" style="display: none;">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="sol_otros" id="sol_otros2" class="form-control" rows="2" placeholder="" required></textarea>
                                            <label for="sol_otros2">Especifique</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="observacion" id="observacion2" class="form-control" rows="2"></textarea>
                                            <label for="observacion2">Observación</label>
                                        </div>
                                    </div>
                                </div>

                                @if(Auth::user()->rol == 30 )
                                    <input type="hidden" name="rif_emp" id="rif_emp2" >
                                @else
                                    <br>
                                    <input type="hidden" name="rif_emp" id="rif_emp2">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="empresa2" name="empresa"   onfocus="getEmpresa('empresa', 'rif_emp', '{!! route('sistema.getEmpresa') !!}')" required >
                                                <label for="empresa2">Empresa (Teclea 2 caracteres para comenzar la busqueda (Nombre o RIF))</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif

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
                            <header>Detalle Encuesta</header>
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
                                <header>Agregar Solicitud</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}">
                                            <label for="fecha">Fecha</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="origen" name="origen" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="MINISTRO (MPPEF)">MINISTRO (MPPEF)</option>
                                                <option value="CONSEJO NACIONAL DE ECONOMÍA PRODUCTIVA (CNEP)">CONSEJO NACIONAL DE ECONOMÍA PRODUCTIVA (CNEP)</option>
                                                <option value="VICEMINISTROS (MPPEF)">VICEMINISTROS (MPPEF)</option>
                                                <option value="FERIAS O EXPOSICIONES">FERIAS O EXPOSICIONES</option>
                                                <option value="OTROS">OTROS</option>
                                            </select>
                                            <label for="origen">Origen de la solicitud</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="ori_especifique" name="ori_especifique" required onfocus="getMPrimaMedida('ori_especifique', '{!! route('sistema.getFeriaEsp') !!}')">
                                                <label for="ori_especifique">Especifique</label>
                                            </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <select id="objeto" name="objeto" class="form-control objeto" required>
                                                <option value="">&nbsp;</option>
                                                @if(Auth::user()->rol == 40)
                                                <option value="PRESENTACIÓN DE PROYECTO">PRESENTACIÓN DE PROYECTO</option>
                                                @else
                                                <option value="PRESENTACIÓN DE PROYECTO">PRESENTACIÓN DE PROYECTO</option>
                                                <option value="FINANCIAMIENTO">FINANCIAMIENTO</option>
                                                <option value="MATERIA PRIMA">MATERIA PRIMA</option>
                                                <option value="PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS">PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS</option>
                                                <option value="OTROS">OTROS</option>
                                                @endif
                                            </select>
                                            <label for="objeto">Objeto de la solicitud</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="proyecto" style="display: none">
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="obj_proyecto" name="obj_proyecto">
                                            <label for="obj_proyecto">Descripción del proyecto (Objeto)</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <select id="tproy" name="tproy" class="form-control" required>
                                                    <option value="">&nbsp;</option>
                                                    <option value="SI">SI</option>
                                                    <option value="NO">NO</option>
                                            </select>
                                            <label for="tproy">Tiene Proyecto</label>
                                        </div>
                                    </div>
                                </div>
                                <!--   -->

                                <div id="finanzas" style="display: none">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" data-type="number" placeholder="Para colocar decimales utilizar coma (,)" class="form-control"  id="fin_montobs" name="fin_montobs" >
                                            <label for="fin_montobs">Monto requerido en bolívares</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" data-type="number" placeholder="Para colocar decimales utilizar coma (,)" class="form-control" id="fin_montousd" name="fin_montousd" >
                                            <label for="fin_montousd">Monto requerido en dolares</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label for="rubros">Para:</label>
                                                <div id="row">
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="c1" name="fin_para[]" type="checkbox" value="MATERIA PRIMA"><span>MATERIA PRIMA</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="c2" name="fin_para[]" type="checkbox" value="INSUMOS O MAQUINARIA Y EQUIPOS"><span>INSUMOS O MAQUINARIA Y EQUIPOS</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="c3" name="fin_para[]" type="checkbox" value="AMPLIACION DE CAPACIDAD INSTALADA"><span>AMPLIACION DE CAPACIDAD INSTALADA</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="row">
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="c4" name="fin_para[]" type="checkbox" value="CAPITAL DE TRABAJO"><span>CAPITAL DE TRABAJO</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="checkbox-inline checkbox-styled">
                                                            <input id="c5" name="fin_para[]" type="checkbox" value="MANTENIMIENTO"><span>MANTENIMIENTO</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--end .form-group -->
                                    </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="fin_banco">Banco(s) de preferencia</label>
                                            <div id="row">
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="b1" name="fin_banco[]" type="checkbox" value="BANCO DE VENEZUELA"><span>BANCO DE VENEZUELA</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="b2" name="fin_banco[]" type="checkbox" value="BANCO DEL TESORO"><span>BANCO DEL TESORO</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="b3" name="fin_banco[]" type="checkbox" value="BANCO BICENTENARIO"><span>BANCO BICENTENARIO</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="row">

                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="b4" name="fin_banco[]" type="checkbox" value="BANCOEX"><span>BANCOEX</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="b5" name="fin_banco[]" type="checkbox" value="BANDES"><span>BANDES</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="b6" name="fin_banco[]" type="checkbox" value="BANCO AGRICOLA"><span>BANCO AGRICOLA</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="row">
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="b7" name="fin_banco[]" type="checkbox" value="BANFANB"><span>BANFANB</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="b9" name="fin_banco[]" type="checkbox" value="BANCO DE LA MUJER"><span>BANCO DE LA MUJER</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="checkbox-inline checkbox-styled">
                                                        <input id="b8" name="fin_banco[]" type="checkbox" value="FONDO GUBERNAMENTAL"><span>FONDO GUBERNAMENTAL</span>
                                                    </label>
                                                </div>

                                               <!-- <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="ob" name="remitido_a[]" >
                                                        <label for="ob">Especifique</label>
                                                    </div>
                                                </div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>



                                </div>

                                <div class="row" id="otros_sol" style="display: none;">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="sol_otros" id="sol_otros" class="form-control" rows="2" placeholder="" required></textarea>
                                            <label for="sol_otros">Especifique</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="observacion" id="observacion" class="form-control" rows="2"></textarea>
                                            <label for="observacion">Observación</label>
                                        </div>
                                    </div>
                                </div>


                                @if(Auth::user()->rol == 30 )
                                    <input type="hidden" name="rif_emp" id="rif_emp" value="{{ Auth::user()->empresa }}" >
                                @else
                                    <br>
                                    <input type="hidden" name="rif_emp" id="rif_emp">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="empresa" name="empresa"   onfocus="getEmpresa('empresa', 'rif_emp', '{!! route('sistema.getEmpresa') !!}')" required >
                                                <label for="empresa">Empresa (Teclea 2 caracteres para comenzar la busqueda (Nombre o RIF))</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif

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

    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="bsqIntFecha" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form-validate" method="post" role="form" id="formBsqFcha" novalidate >
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Busqueda intervalo de fecha</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required >
                                            <label for="fecha_inicio">Fecha inicio</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required >
                                            <label for="fecha_fin">Fecha fin</label>
                                        </div>
                                    </div>
                                </div>
                                <!--   -->
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnBqdFcha">Buscar</button>
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




    <script>
        $.extend($.inputmask.defaults.definitions, {
            'R': {  //masksymbol
                "validator": "[vVeEjJgG]",
                "cardinality": 1,
                'prevalidator': null
            }
        });

       $(function() {

            $("input[data-type='number']").inputmask("decimal", {
                radixPoint: ",",
                autoGroup: true,
                groupSeparator: ".",
                groupSize: 3,
                autoUnmask: true
            });/* */

            $('.objeto').change(function(){
                if($(this).attr('id')== 'objeto'){
                    switch($(this).val()){
                        case 'PRESENTACIÓN DE PROYECTO':
                            $('#finanzas, #otros_sol').hide("fast");
                            $('#proyecto').show("slow");
                        break;
                        case 'FINANCIAMIENTO':
                            $('#proyecto, #otros_sol').hide("fast");
                            $('#finanzas').show("slow");
                        break;
                        case 'OTROS':
                            $('#proyecto, #finanzas').hide("fast");
                            $('#otros_sol').show("slow");
                        break;
                        default:
                            $('#proyecto, #finanzas,#otros_sol').hide("fast");
                        break;
                    }
                }
                else{
                    switch($(this).val()){
                        case 'PRESENTACIÓN DE PROYECTO':
                            $('#finanzas2, #otros_sol2').hide("fast");
                            $('#proyecto2').show("slow");
                            break;
                        case 'FINANCIAMIENTO':
                            $('#proyecto2, #otros_sol2').hide("fast");
                            $('#finanzas2').show("slow");
                            break;
                        case 'OTROS':
                            $('#proyecto2, #finanzas2').hide("fast");
                            $('#otros_sol2').show("slow");
                            break;
                        default:
                            $('#proyecto2, #finanzas2,#otros_sol2').hide("fast");
                            break;
                    }
                }
            })

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
                "order": [[ 0, "desc" ]],
               dom: 'Blfrtip',
                buttons: [
                    {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o"></i>',titleAttr: 'Excel', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs'},
                    {extend:'pdfHtml5',text:'<i class="fa fa-file-pdf-o"></i>',titleAttr: 'PDF', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs', orientation: 'landscape', pageSize: 'LEGAL'},
                    {text: '<i class="fa fa-calendar"></i>',className: 'btn ink-reaction btn-floating-action btn-primary btn-xs',titleAttr: 'Busqueda intérvalo de fecha', action: function ( e, dt, node, config ){
                            $( '#bsqIntFecha' ).modal('show');
                        }
                    }
                ],
                language: {
                    url: '{{ URL::to('assets/js/libs/DataTables/spanish.json') }}'
                },
                ajax: {
                    url: '{!! route('sistema.solicitudes.data') !!}',
                    data: function (d) {
                        d.fecha_inicio = $('input[name=fecha_inicio]').val();
                        d.fecha_fin = $('input[name=fecha_fin]').val();
                    }
                    //method: 'POST'
                },
                columns:
                [
                { data: 'id', name: 'solicitudes.id'  },
                { data: 'fecha', name: 'solicitudes.fecha' },
                { data: 'empresa', name: 'empresas.empresa' },
                { data: 'origen', name: 'solicitudes.origen' },
                { data: 'ori_especifique', name: 'solicitudes.ori_especifique', orderable: false, searchable: false, visible: false },
                { data: 'objeto', name: 'solicitudes.objeto'},
                { data: 'obj_proyecto', name: 'solicitudes.obj_proyecto', orderable: false, searchable: false, visible: false  },
                { data: 'tproy', name: 'solicitudes.tproy', orderable: false, searchable: false, visible: false  },
                { data: 'fin_montobs', name: 'solicitudes.fin_montobs', orderable: false, searchable: false, visible: false  },
                { data: 'fin_montousd', name: 'solicitudes.fin_montousd', orderable: false, searchable: false, visible: false  },
                { data: 'fin_para', name: 'solicitudes.fin_para', orderable: false, searchable: false, visible: false  },
                { data: 'fin_banco', name: 'solicitudes.fin_banco', orderable: false, searchable: false, visible: false  },
                { data: 'sol_otros', name: 'solicitudes.sol_otros', orderable: false, searchable: false, visible: false  },
                { data: 'observacion', name: 'solicitudes.observacion', orderable: false, searchable: false, visible: false  },
                { data: 'accion', name: 'accion', orderable: false, searchable: false }
                ]
            });


            fbsqf = $('#formBsqFcha');
            fbsqf.validate();
            $('#btnBqdFcha').click(function(){
                if(fbsqf.valid()){
                    table.page.len( -1 ).draw();
                    //table.draw();
                    $('#bsqIntFecha').modal('hide');
                }
            })

            $('#bsqIntFecha').on('hidden.bs.modal', function (e) {
                fbsqf.clearForm();
            })

            

            $("#btnAddEmp").click(function(){
                $("#formAddEmp").clearForm();
                $('#proyecto, #finanzas, #otros_sol').hide();
                $("#formAddEmp").modal('show');
            })

            var fAddEmp = $("#addEmp");
            fAddEmp.validate();
            $('#btnAddOfic').click(function(){
                if(fAddEmp.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.solicitudes.add') !!}',
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
                    url:'{!! route('sistema.solicitudes.find') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {
                        $.each(data, function(i, item) {

                            $("#id_mp").val(item.id);


                            $("#fecha2").val(item.fecha);
                            $('#origen2').append($('<option>').text(item.origen).attr({value: item.origen,selected: "selected"}));
                            $('#tproy2').append($('<option>').text(item.tproy).attr({value: item.tproy,selected: "selected"}));
                            $("#ori_especifique2").val(item.ori_especifique);
                            $("#objeto2").val(item.objeto);
                            $("#obj_proyecto2").val(item.obj_proyecto);
                            $("#fin_montobs2").val(item.fin_montobs);
                            $("#fin_montousd2").val(item.fin_montousd);
                            $("#sol_otros2").val(item.sol_otros);
                            $("#rif_emp2").val(item.emp_rif);
                            $("#empresa2").val(item.empresa);
                            $("#observacion2").text(item.observacion).val(item.observacion);

                            if(item.obj_proyecto !== ''){
                                $('#proyecto2').show("slow");
                            }
                            if(item.fin_para !== ''){
                                $('#finanzas2').show("slow");
                            }
                            if(item.sol_otros !== ''){
                                $('#otros_sol2').show("slow");
                            }


                            para = item.fin_para.split(',')

                            for(i = 0; i < para.length; i++){
                                switch(para[i]){
                                    case 'MATERIA PRIMA':
                                        $('#c12').prop('checked', true);
                                        break;
                                    case 'INSUMOS O MAQUINARIA Y EQUIPOS':
                                        $('#c22').prop('checked', true);
                                        break;
                                    case 'AMPLIACION DE CAPACIDAD INSTALADA':
                                        $('#c32').prop('checked', true);
                                        break;
                                    case 'CAPITAL DE TRABAJO':
                                        $('#c42').prop('checked', true);
                                        break;
                                    case 'MANTENIMIENTO':
                                        $('#c52').prop('checked', true);
                                        break;
                                }
                            }

                            //alert(item.fin_banco !== null)


                            if(item.fin_banco !== null ){
                                banco = item.fin_banco.split(',');

                                for(i = 0; i < banco.length; i++){
                                    switch(banco[i]){
                                        case 'BANCO DE VENEZUELA':
                                            $('#b12').prop('checked', true);
                                            break;
                                        case 'BANCO DEL TESORO':
                                            $('#b22').prop('checked', true);
                                            break;
                                        case 'BANCO BICENTENARIO':
                                            $('#b32').prop('checked', true);
                                            break;
                                        case 'BANCOEX':
                                            $('#b42').prop('checked', true);
                                            break;
                                        case 'BANDES':
                                            $('#b52').prop('checked', true);
                                            break;
                                        case 'BANCO AGRICOLA':
                                            $('#b62').prop('checked', true);
                                            break;
                                        case 'BANFANB':
                                            $('#b72').prop('checked', true);
                                            break;
                                        case 'FONDO GUBERNAMENTAL':
                                            $('#b82').prop('checked', true);
                                            break;
                                        case 'BANCO DE LA MUJER':
                                            $('#b92').prop('checked', true);
                                            break;
                                    }
                                }
                            }

                        })
                        $("#formActEmp").modal('show');
                    }
                });

            }

            var fActEmp = $("#actEmp");

            $('#formActEmp').on('hidden.bs.modal', function (e) {
                $("#tipo2 option:last, #descripcion2 option:last").remove();
                $('#proyecto2, #finanzas2, #otros_sol2').hide();
                fActEmp.clearForm();
            })

            fActEmp.validate();
            $('#btnActEmpr').click(function(){
                if(fActEmp.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.solicitudes.upd') !!}',
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
                        url:'{!! route('sistema.solicitudes.del') !!}',
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
               // $("#detalleEmp").modal('show');

                $.ajax({
                    type: "POST",
                    url:'{!! route('sistema.solicitudes.view') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {
                            $("#divEmpDet").empty().html(data);
                            $("#detalleEmp").modal('show');
                    }
                });
            }

           aprobar = function(id){
               swal({
                   title: "¿Esta seguro que quiere aprobar/no aprobar esta solicitud?",
                   text: "Esta acción no puede ser desecha",
                   type: "warning",
                   cancelButtonText: "No",
                   showCancelButton: true,
                   confirmButtonText: "Si, estoy seguro",
                   reverseButtons: true,
                   html:
                       '<div class="form-group">'+
                       '<select id="statusSolicitud" class="form-control">'+
                       '<option value="">&nbsp;</option>'+
                       '<option value="APROBADO">APROBADO</option>'+
                       '<option value="NO APROBADO">NO APROBADO</option>'+
                       '</select>'+
                       '</div>'
               }).then(function (text) {
                   if($('#statusSolicitud').val() == ''){
                       alert('Debe eligir una opción de la lista');
                   }
                   else{
                       $.ajax({
                           type: "POST",
                           url:'{!! route('sistema.solicitudes.apro') !!}',
                           data: {"_token": "{{ csrf_token() }}", "id": id, "statusSol": $('#statusSolicitud').val()},
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
                   }
               });
           }

           resetAprobar = function(id){
               swal({
                   title: "¿Esta seguro que quiere resetear el estatus de esta solicitud?",
                   text: "",
                   type: "warning",
                   cancelButtonText: "No",
                   showCancelButton: true,
                   confirmButtonText: "Si, estoy seguro",
                   reverseButtons: true
               }).then(function (text) {
                   $.ajax({
                       type: "POST",
                       url:'{!! route('sistema.solicitudes.rapr') !!}',
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

        });
    </script>
@endsection