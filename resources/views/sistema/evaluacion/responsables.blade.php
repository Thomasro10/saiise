@extends('layouts.master')

@section('title')
    .:: Evaluación responsables ::.
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
    Evaluación responsables
@endsection

@section('content')
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
        <div class="card">
            <div class="card-head">
                <ul class="nav nav-tabs" data-toggle="tabs">
                    <li class="active"><a href="#first1">Responsables</a></li>
                    <li><a href="#second1">Asignacion de proyectos</a></li>
                </ul>
            </div><!--end .card-head -->
            <div class="card-body tab-content">
                <div class="tab-pane active" id="first1">
                    @if( Auth::user()->rol != 3 )
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button" class="btn ink-reaction btn-floating-action btn-sm btn-primary pull-right" id="btnAddEmp" title="Agregar registro">
                                    <i class="fa fa-plus-square"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="dt_resp" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="sort-numeric">Cedula</th>
                                <th class="sort-alpha">Nombre</th>
                                <th class="sort-alpha">Perfil</th>
                                <th class="sort-alpha">Módulo</th>
                                <th class="sort-alpha">Estatus</th>
                                <th class="sort-alpha">&nbsp;</th>
                            </tr>
                            </thead>
                        </table>
                    </div><!--end .table-responsive -->
                </div>
                <div class="tab-pane" id="second1">
                    <div class="table-responsive">
                        <table id="dt_sol" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="sort-numeric">ID</th>
                                <th class="sort-alpha">Fecha solicitud</th>
                                <th class="sort-alpha">RIF</th>
                                <th class="sort-alpha">Empresa</th>
                                <th class="sort-alpha">Objeto solicitud</th>
                                <th class="sort-alpha">Objeto proyecto</th>
                                <th class="sort-alpha">Observación</th>
                                <th class="sort-alpha" title="Evaluación Legal">EL</th>
                                <th class="sort-alpha" title="Evaluación Economico-social">EE</th>
                                <th class="sort-alpha" title="Evaluación Fianaciera">EF</th>
                                <th class="sort-alpha" title="Evaluación de Ingenieria de diseño">EI</th>
                                <th class="sort-alpha">&nbsp;</th>
                            </tr>
                            </thead>
                        </table>
                    </div><!--end .table-responsive -->
                </div>
            </div><!--end .card-body -->
        </div><!--end .card -->
        </div><!--end .col -->
    </div><!--end .row -->

    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="formActEmp" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form-validate" role="form" id="actEmp" novalidate >
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <input type="hidden" name="id" id="id_resp">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Actualizar Responsable</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cedula2" name="cedula" data-type="number" required>
                                            <label for=cedula2">Cédula</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nombre2" name="nombre" required>
                                            <label for="nombre2">Nombre</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="perfil2" name="perfil" class="form-control objeto" required>
                                                <option value="">&nbsp;</option>
                                                <optgroup label="Evaluación legal">
                                                    <option value="ABOGADO(A)">ABOGADO(A)</option>
                                                </optgroup>
                                                <optgroup label="Evaluación económico-social">
                                                    <option value="ANALISTA EN BANCA Y FINANZA">ANALISTA EN BANCA Y FINANZA</option>
                                                    <option value="INGENIERO(A) CIVIL">INGENIERO(A) CIVIL</option>
                                                    <option value="ADMINISTRADOR(A) DE EMPRESAS">ADMINISTRADOR(A) DE EMPRESAS</option>
                                                    <option value="ECONOMISTA">ECONOMISTA</option>
                                                    <option value="LCDO(A) EN CIENCIAS FISCALES">LCDO(A) EN CIENCIAS FISCALES</option>
                                                </optgroup>
                                                <optgroup label="Evaluación de ingeniería de diseño">
                                                    <option value="ARQUITECTO(A)">ARQUITECTO(A)</option>
                                                    <option value="INGENIERO(A) CIVIL">INGENIERO(A) CIVIL</option>
                                                    <option value="INGENIERO(A) MECANICO">INGENIERO(A) MECANICO</option>
                                                    <option value="INGENIERO(A) INDUSTRIAL">INGENIERO(A) INDUSTRIAL</option>
                                                    <option value="INGENIERO(A) AGRICOLA">INGENIERO(A) AGRICOLA</option>
                                                    <option value="LCDO(A) EN ADMINISTRACION">LCDO(A) EN ADMINISTRACION</option>
                                                </optgroup>
                                                <optgroup label="Evaluación financiera">
                                                    <option value="ECONOMISTA)">ECONOMISTA</option>
                                                    <option value="CONTADOR(A)">CONTADOR(A)</option>
                                                    <option value="LCDO(A) EN CIENCIAS FISCALES">LCDO(A) EN CIENCIAS FISCALES</option>
                                                    <option value="LCDO(A) EN ADMINISTRACION">LCDO(A) EN ADMINISTRACION</option>
                                                </optgroup>
                                            </select>
                                            <label for="perfil2">Perfil</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="modulo2" name="modulo" class="form-control objeto" required>
                                                <option value="">&nbsp;</option>
                                                <option value="EVALUACION LEGAL">EVALUACION LEGAL</option>
                                                <option value="EVALUACION ECONOMICO-SOCIAL">EVALUACION ECONOMICO-SOCIAL</option>
                                                <option value="EVALUACION DE INGENIERIA DE DISEÑO">EVALUACION DE INGENIERIA DE DISEÑO</option>
                                                <option value="EVALUACION FINANCIERA">EVALUACION FINANCIERA</option>
                                            </select>
                                            <label for="modulo2">Módulo</label>
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
                                <header>Agregar Responsable</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cedula" name="cedula" data-type="number" required>
                                            <label for="cedula">Cédula</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                                            <label for="nombre">Nombre</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="perfil" name="perfil" class="form-control objeto" required>
                                                <option value="">&nbsp;</option>
                                                <optgroup label="Evaluación legal">
                                                    <option value="ABOGADO(A)">ABOGADO(A)</option>
                                                </optgroup>
                                                <optgroup label="Evaluación económico-social">
                                                    <option value="ANALISTA EN BANCA Y FINANZA">ANALISTA EN BANCA Y FINANZA</option>
                                                    <option value="INGENIERO(A) CIVIL">INGENIERO(A) CIVIL</option>
                                                    <option value="ADMINISTRADOR(A) DE EMPRESAS">ADMINISTRADOR(A) DE EMPRESAS</option>
                                                    <option value="ECONOMISTA">ECONOMISTA</option>
                                                    <option value="LCDO(A) EN CIENCIAS FISCALES">LCDO(A) EN CIENCIAS FISCALES</option>
                                                </optgroup>
                                                <optgroup label="Evaluación de ingeniería de diseño">
                                                    <option value="ARQUITECTO(A)">ARQUITECTO(A)</option>
                                                    <option value="INGENIERO(A) CIVIL">INGENIERO(A) CIVIL</option>
                                                    <option value="INGENIERO(A) MECANICO">INGENIERO(A) MECANICO</option>
                                                    <option value="INGENIERO(A) INDUSTRIAL">INGENIERO(A) INDUSTRIAL</option>
                                                    <option value="INGENIERO(A) AGRICOLA">INGENIERO(A) AGRICOLA</option>
                                                    <option value="LCDO(A) EN ADMINISTRACION">LCDO(A) EN ADMINISTRACION</option>
                                                </optgroup>
                                                <optgroup label="Evaluación financiera">
                                                    <option value="ECONOMISTA">ECONOMISTA</option>
                                                    <option value="CONTADOR(A)">CONTADOR(A)</option>
                                                    <option value="LCDO(A) EN CIENCIAS FISCALES">LCDO(A) EN CIENCIAS FISCALES</option>
                                                    <option value="LCDO(A) EN ADMINISTRACION">LCDO(A) EN ADMINISTRACION</option>
                                                </optgroup>
                                            </select>
                                            <label for="perfil">Perfil</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="modulo" name="modulo" class="form-control objeto" required>
                                                <option value="">&nbsp;</option>
                                                <option value="EVALUACION LEGAL">EVALUACION LEGAL</option>
                                                <option value="EVALUACION ECONOMICO-SOCIAL">EVALUACION ECONOMICO-SOCIAL</option>
                                                <option value="EVALUACION DE INGENIERIA DE DISEÑO">EVALUACION DE INGENIERIA DE DISEÑO</option>
                                                <option value="EVALUACION FINANCIERA">EVALUACION FINANCIERA</option>
                                            </select>
                                            <label for="modulo">Módulo</label>
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

    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="modalAsigResp" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form-validate" method="post" role="form" id="formAsigResp" novalidate >
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <input type="hidden" name="sol_id" id="sol_id">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Asignar responsable</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <select id="evaluacion" name="evaluacion" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="EVALUACION LEGAL">EVALUACION LEGAL</option>
                                                <option value="EVALUACION ECONOMICO-SOCIAL">EVALUACION ECONOMICO-SOCIAL</option>
                                                <option value="EVALUACION DE INGENIERIA DE DISEÑO">EVALUACION DE INGENIERIA DE DISEÑO</option>
                                                <option value="EVALUACION FINANCIERA">EVALUACION FINANCIERA</option>
                                            </select>
                                            <label for="evaluacion">Módulo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <select id="resp_id" name="resp_id" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                            </select>
                                            <label for="resp_id">Responsable</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="dt_asigeva" class="table table-striped table-hover" width="100$">
                                                <thead>
                                                <tr>
                                                    <th class="sort-alpha" width="34%">Evaluación</th>
                                                    <th class="sort-alpha" width="33%">Responsable</th>
                                                    <th class="sort-alpha" width="33%">Fecha</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div><!--end .table-responsive -->
                                    </div>
                                </div>

                                <!--   -->
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnAsigResp">Asignar</button>
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ Session::token() }}'
                }
            });

            $(":input").inputmask();
            /*********************************************************************/
            table_sol = $('#dt_sol').DataTable({
               processing: true,
               serverSide: true,
               responsive: true,
               // autoWidth: false,
               lengthMenu: [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "All"]],
               order: [[ 0, "desc" ]],
               dom: 'Blfrtip',
               buttons: [
                   {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o"></i>',titleAttr: 'Excel', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs'},
                   {extend:'pdfHtml5',text:'<i class="fa fa-file-pdf-o"></i>',titleAttr: 'PDF', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs', orientation: 'landscape', pageSize: 'LEGAL'},
                   /*{text: '<i class="fa fa-calendar"></i>',className: 'btn ink-reaction btn-floating-action btn-primary btn-xs',titleAttr: 'Busqueda intérvalo de fecha', action: function ( e, dt, node, config ){
                       $( '#bsqIntFecha' ).modal('show');
                   }
                   }*/
               ],
               language: {
                   url: '{{ URL::to('assets/js/libs/DataTables/spanish.json') }}'
               },
               ajax: {
                   url: '{!! route('sistema.eproyecto.responsables.asig') !!}',
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
                       { data: 'emp_rif', name: 'solicitudes.emp_rif', orderable: false, searchable: false, visible: false },
                       { data: 'empresa', name: 'empresas.empresa' , "width": "30%" },
                       { data: 'objeto', name: 'solicitudes.objeto', orderable: false, searchable: false, visible: false  },
                       { data: 'obj_proyecto', name: 'solicitudes.obj_proyecto'},
                       { data: 'observacion', name: 'solicitudes.observacion', orderable: false, searchable: false, visible: false  },
                       { data: 'el', name: 'el', orderable: false, searchable: false },
                       { data: 'ee', name: 'ee', orderable: false, searchable: false },
                       { data: 'ef', name: 'ef', orderable: false, searchable: false },
                       { data: 'ei', name: 'ei', orderable: false, searchable: false },
                       { data: 'accion', name: 'accion', orderable: false, searchable: false }
                   ]
           });
            /********************************************************************/
            table = $('#dt_resp').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthMenu: [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "All"]],
                order: [[ 0, "asc" ]],
                dom: 'Blfrtip',
                buttons: [
                    {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o"></i>',titleAttr: 'Excel', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs'},
                    {extend:'pdfHtml5',text:'<i class="fa fa-file-pdf-o"></i>',titleAttr: 'PDF', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs', orientation: 'landscape', pageSize: 'LEGAL'},
                ],
                language: {
                    url: '{{ URL::to('assets/js/libs/DataTables/spanish.json') }}'
                },
                ajax: {
                    url: '{!! route('sistema.eproyecto.responsables.data') !!}',
                    data: function (d) {
                        d.fecha_inicio = $('input[name=fecha_inicio]').val();
                        d.fecha_fin = $('input[name=fecha_fin]').val();
                    }
                    //method: 'POST'
                },
                columns:
                [
                { data: 'cedula', name: 'eva_responsables.cedula'  },
                { data: 'nombre', name: 'eva_responsables.nombre' },
                { data: 'perfil', name: 'eva_responsables.perfil' },
                { data: 'modulo', name: 'eva_responsables.modulo' },
                { data: 'status', name: 'eva_responsables.status' },

                { data: 'accion', name: 'accion', orderable: false, searchable: false }
                ]
            });

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
                        url:'{!! route('sistema.eproyecto.responsables.add') !!}',
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
                    url:'{!! route('sistema.eproyecto.responsables.find') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {
                        $.each(data, function(i, item) {

                            $("#id_resp").val(item.id);

                            $("#cedula2").val(item.cedula);
                            $("#nombre2").val(item.nombre);
                            $('#perfil2').append($('<option>').text(item.perfil).attr({value: item.perfil,selected: "selected"}));
                            $('#modulo2').append($('<option>').text(item.modulo).attr({value: item.modulo,selected: "selected"}));


                        })
                        $("#formActEmp").modal('show');
                    }
                });

            }

            var fActEmp = $("#actEmp");

            $('#formActEmp').on('hidden.bs.modal', function (e) {
                $("#perfil2 option:last, #modulo2 option:last").remove();
                fActEmp.clearForm();
            })

            fActEmp.validate();
            $('#btnActEmpr').click(function(){
                if(fActEmp.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.eproyecto.responsables.upd') !!}',
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

            deleteEnc = function(id, ced){
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
                        url:'{!! route('sistema.eproyecto.responsables.del') !!}',
                        data: {"_token": "{{ csrf_token() }}", "id": id, "cedula": ced},
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

           actDesResp = function(id, sta, ced){
               swal({
                   title: "¿Esta seguro que quiere modificar este registro?",
                   type: "warning",
                   cancelButtonText: "No",
                   showCancelButton: true,
                   confirmButtonText: "Si, estoy seguro",
                   reverseButtons: true
               }).then(function (text) {
                   $.ajax({
                       type: "POST",
                       url:'{!! route("sistema.eproyecto.responsables.ades") !!}',
                       data: {"_token": "{{ csrf_token() }}", "id": id, "status": sta, "cedula":ced},
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

           verDataAsigResp = function(id){
               $.ajax({
                   dataType: "json",
                   url: '{!! route('sistema.eproyecto.responsables.viewAsig') !!}',
                   data: { "id": id, rand: Math.random() },
                   success: function(data) {
                       $('#dt_asigeva tbody').empty();
                       $.each(data, function(i, item) {
                           $('#dt_asigeva tbody').append('<tr><td>'+item.evaluacion+'</td><td>'+item.nombre+'</td><td>'+item.fecha+'</td></tr>');
                       });
                   }
               });
           }

           asigResponsable = function(id){
               $('#sol_id').val(id);
               verDataAsigResp(id);
               $('#modalAsigResp').modal('show');
           }

           var fAddAsigResp = $("#formAsigResp");
           fAddAsigResp.validate();
           $('#btnAsigResp').click(function(){
               if(fAddAsigResp.valid()){
                   //alert(fAddAsigResp.serialize())
                   $.ajax({
                       type: "POST",
                       url:'{!! route('sistema.eproyecto.responsables.addAsigEva') !!}',
                       data: fAddAsigResp.serialize(),
                       success: function( data ) {
                          if(data.status == 1){
                               swal(data.msg, "", "success");
                               verDataAsigResp(data.sol_id);
                              table_sol.ajax.reload( null, false );
                               fAddAsigResp.clearForm();
                           }
                           else{
                               swal(data.msg, "", "error");
                           }
                       }
                   });
               }
           })

           $('#modalAsigResp').on('hidden.bs.modal', function (e) {
               $('#resp_eva').find('option:not(:first)').remove();
               fAddAsigResp.clearForm();
               $('#dt_asigeva tbody').empty();
           })

           $('#evaluacion').change(function () {
               if($('#evaluacion').val() != ''){
                   $.ajax({
                       dataType: "json",
                       url: '{{ route('sistema.getRespMod') }}',
                       data: { evaluacion: $('#evaluacion').val(), rand: Math.random() },
                       success: function(data) {
                           $('#resp_id').find('option:not(:first)').remove();
                           $.each(data, function(i, item) {
                               $('#resp_id').append($('<option>').text(item.label).attr('value', item.value));
                           });
                       },
                       complete:function(){ $('#evaluacion').removeClass('ui-autocomplete-loading'); }
                   });
               }
               else{
                   $('#resp_id').find('option:not(:first)').remove();
               }
           })
        });
    </script>
@endsection