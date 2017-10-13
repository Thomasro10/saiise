@extends('layouts.master')

@section('title')
    .:: Logros ::.
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
    Logros
@endsection

@section('content')

    <div class="row">

        <div class="col-lg-12">
            <button type="button" class="btn ink-reaction btn-floating-action btn-sm btn-primary pull-right" id="btnAddEmp" title="Agregar registro">
                <i class="fa fa-plus-square"></i>
            </button>
        </div>

    </div>
    @if (Auth::user()->rol != 30 )

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dt_emp" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="sort-numeric">ID</th>
                        <th class="sort-alpha">Empresa</th>
                        <th class="sort-alpha">Fecha</th>
                        <th class="sort-alpha">Logro</th>
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
                        <input type="hidden" name="id" id="id_lg">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Actualizar Logro</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="fecha2" name="fecha" required>
                                            <label for="fecha2">Fecha</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="logro" id="logro2" class="form-control" rows="2" placeholder="" required></textarea>
                                            <label for="logro2">Logro</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="rif_enc" id="rif_enc2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="empresa2" name="empresa"   onfocus="getEmpresa('empresa2', 'rif_enc2', '{!! route('sistema.getEmpresa') !!}')" required >
                                            <label for="empresa2">Empresa (Teclea 2 caracteres para comenzar la busqueda (Nombre o RIF))</label>
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
    @endif

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
                                <header>Agregar Logro</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                                            <label for="fecha">Fecha</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="logro" id="logro" class="form-control" rows="2" placeholder="" required></textarea>
                                            <label for="logro">Logro</label>
                                        </div>
                                    </div>
                                </div>


                                <input type="hidden" name="rif_enc" id="rif_enc">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="empresa" name="empresa" onfocus="getEmpresa('empresa', 'rif_enc', '{!! route('sistema.getEmpresa') !!}')" required >
                                            <label for="empresa">Empresa (Teclea 2 caracteres para comenzar la busqueda (Nombre o RIF))</label>
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
                    url: '{!! route('sistema.logros.data') !!}',
                    method: 'POST'
                },
                columns:
                [
                { data: 'id', name: 'logros.id'  },
                { data: 'empresa', name: 'encuestas.empresa' },
                { data: 'fecha', name: 'fecha' },
                { data: 'logro', name: 'logros.logro', orderable: false, searchable: false },
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
                        url:'{!! route('sistema.logros.add') !!}',
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
                    url:'{!! route('sistema.logros.find') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {
                        $.each(data, function(i, item) {

                            $("#id_lg").val(item.id);
                            $("#rif_enc2").val(item.rif_enc);
                            $("#fecha2").val(item.fecha);
                            $("#logro2").text(item.logro);
                            $("#empresa2").val(item.empresa);


                        })
                        $("#formActEmp").modal('show');
                    }
                });

            }

            var fActEmp = $("#actEmp");

            $('#formActEmp').on('hidden.bs.modal', function (e) {
                //$("#tipo2 option:last, #descripcion2 option:last").remove();
                fActEmp.clearForm();
            })

            fActEmp.validate();
            $('#btnActEmpr').click(function(){
                if(fActEmp.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.logros.upd') !!}',
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
                        url:'{!! route('sistema.logros.del') !!}',
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
                    url:'{!! route('sistema.logros.view') !!}',
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
                                    '<div class="col-sm-3">Materia Prima: <b>'+item.requerimientos+'</b></div>' +
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