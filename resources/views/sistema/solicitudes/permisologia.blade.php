@extends('layouts.master')

@section('title')
    .:: Permisología ::.
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
    Permisología
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
        <!---<div class="row">
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
                        <th class="sort-alpha" width="20%">Empresa</th>
                        <th class="sort-alpha" width="20%">Solicitud</th>
                        <th class="sort-alpha">Institución</th>
                        <th class="sort-alpha" width="30%">Descripcion</th>
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
                        <input type="hidden" name="id" id="id_mp">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Actualizar permisología, licencias, certificados u trámites varios</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="institucion2" name="institucion" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SENCAMER">SENCAMER</option>
                                                <option value="FODENORCA">FODENORCA</option>
                                                <option value="RESQUIMC">RESQUIMC</option>
                                                <option value="INAPYMI">INAPYMI</option>
                                                <option value="FONDOIN">FONDOIN</option>
                                                <option value="ZONFIPCA">ZONFIPCA</option>
                                                <option value="DIRECCION GENERAL DE CONTROL Y PROMOCION DE LA INDUSTRIA">DIRECCION GENERAL DE CONTROL Y PROMOCION DE LA INDUSTRIA</option>
                                                <option value="OTROS">OTROS</option>
                                            </select>
                                            <label for="institucion2">Institución</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="ot_especifique2" name="ot_especifique">
                                            <label for="ot_especifique2">Si es otra, especifique</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="descripcion2" name="descripcion" required >
                                            <label for="descripcion2">Tipo de permisología, licencias, certificados u trámites varios</label>
                                        </div>
                                    </div>
                                </div>


                                    <input type="hidden" name="id_sol" id="id_sol2">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="solicitud2" name="solicitud" onfocus="getSolicitud('solicitud2', 'id_sol2', '{!! route('sistema.getSolicitud') !!}')" required >
                                                <label for="solicitud2">Solicitud (Teclea 1 caracter para comenzar la busqueda (Id, fecha, Empresa, objeto solicitud u origen solicitud))</label>
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
                                <header>Agregar permisología, licencias, certificados u trámites varios</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="institucion" name="institucion" class="form-control" required>
                                                <option value="">&nbsp;</option>

                                                <option value="SENCAMER">SENCAMER</option>
                                                <option value="FODENORCA">FODENORCA</option>
                                                <option value="RESQUIMC">RESQUIMC</option>
                                                <option value="INAPYMI">INAPYMI</option>
                                                <option value="FONDOIN">FONDOIN</option>
                                                <option value="ZONFIPCA">ZONFIPCA</option>
                                                <option value="DIRECCION GENERAL DE CONTROL Y PROMOCION DE LA INDUSTRIA">DIRECCION GENERAL DE CONTROL Y PROMOCION DE LA INDUSTRIA</option>
                                                <option value="OTROS">OTROS</option>
                                            </select>
                                            <label for="institucion">Institución</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <input type="text" class="form-control" id="ot_especifique" name="ot_especifique">
                                                <label for="ot_especifique">Si es otra, especifique</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="descripcion" name="descripcion" required >
                                            <label for="descripcion">Tipo de permisología, licencias, certificados u trámites varios</label>
                                        </div>
                                    </div>
                                </div>

                                    <input type="hidden" name="id_sol" id="id_sol">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="solicitud" name="solicitud" onfocus="getSolicitud('solicitud', 'id_sol', '{!! route('sistema.getSolicitud') !!}')" required >
                                                <label for="solicitud">Solicitud (Teclea 1 caracter para comenzar la busqueda (Id, fecha, Empresa, objeto solicitud u origen solicitud))</label>
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
                    url: '{!! route('sistema.permisologia.data') !!}',
                    method: 'POST'
                },
                columns:
                [
                { data: 'id', name: 'permisologia.id'  },
                { data: 'empresa', name: 'empresas.empresa' },
                { data: 'solicitud', name: 'solucitud' },
                { data: 'institucion', name: 'permisologia.institucion' },
                { data: 'descripcion', name: 'permisologia.descripcion', orderable: false, searchable: false },
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
                        url:'{!! route('sistema.permisologia.add') !!}',
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
                    url:'{!! route('sistema.permisologia.find') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {
                        $.each(data, function(i, item) {

                            $("#id_mp").val(item.id);
                            $("#institucion2").append($('<option>').text(item.institucion).attr({value: item.institucion,selected: "selected"}));
                            $("#ot_especifique2").val(item.ot_especifique)
                            $("#descripcion2").val(item.descripcion);
                            $("#id_sol2").val(item.id_sol);
                            $("#solicitud2").val(item.solicitud);


                        })
                        $("#formActEmp").modal('show');
                    }
                });

            }

            var fActEmp = $("#actEmp");

            $('#formActEmp').on('hidden.bs.modal', function (e) {
                $("#tipo2 option:last, #descripcion2 option:last").remove();
                fActEmp.clearForm();
            })

            fActEmp.validate();
            $('#btnActEmpr').click(function(){
                if(fActEmp.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.permisologia.upd') !!}',
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
                        url:'{!! route('sistema.permisologia.del') !!}',
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
                    url:'{!! route('sistema.permisologia.view') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {
                        $.each(data, function(i, item) {
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
                                    '<div class="col-sm-3">Materia Prima: <b>'+item.permisologia+'</b></div>' +
                                    '<div class="col-sm-3">Descripción: <b>'+item.descripcion+'</b></div>' +
                                    '</div>';
                            html += '<div class="row">' +
                                    '<div class="col-sm-6">Mercado a abastecer: <b>'+item.mercabast+'</b></div>' +
                                    '<div class="col-sm-6">Principal rubro: <b>'+item.rubros+'</b></div>' +
                                    '</div>';
                            html += '<div class="row">' +
                                    '<div class="col-sm-12">Obstaculos: <b>'+item.obstaculos+'</b></div>' +
                                    '</div>';

                            $("#divEmpDet").empty().html(html);
                            $("#detalleEmp").modal('show');
                        })
                    }
                });
            }

        });
    </script>
@endsection