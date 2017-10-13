@extends('layouts.master')

@section('title')
    .:: Requerimientos ::.
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
    Requerimientos
@endsection

@section('content')

    @if(Auth::user()->rol != 3 )
    <div class="row">
        <div class="col-lg-12">
            <button type="button" class="btn ink-reaction btn-floating-action btn-sm btn-primary pull-right" id="btnAddEmp" title="Agregar registro">
                <i class="fa fa-plus-square"></i>
            </button>
        </div>
    </div>
    @endif


    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dt_emp" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="sort-numeric">ID</th>
                        <th class="sort-alpha">Empresa</th>
                        <th class="sort-alpha">Requerimiento</th>
                        <th class="sort-alpha">Posible solución</th>
                        <th class="sort-alpha">Posible acción</th>
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
                        <input type="hidden" name="id" id="id_rq">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Actualizar Requerimiento</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="requerimiento2" name="requerimiento" required>
                                            <label for="requerimiento2">Requerimiento</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="solucion2" name="solucion">
                                            <label for="solucion2">Posible solución</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="acuerdo2" name="acuerdo">
                                            <label for="acuerdo2">Posible acción</label>
                                        </div>
                                    </div>
                                </div>
                                @if(Auth::user()->rol == 30 )
                                    <input type="hidden" name="rif_emp" id="rif_emp" value="{{ Auth::user()->empresa }}">
                                @else
                                <input type="hidden" name="rif_emp" id="rif_emp2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="empresa2" name="empresa"   onfocus="getEmpresa('empresa2', 'rif_emp2', '{!! route('sistema.getEmpresa') !!}')" required >
                                            <label for="empresa2">Empresa (Teclea 2 caracteres para comenzar la busqueda (Nombre o RIF(Ej. J-00000000-0))</label>
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
                                <header>Agregar Requerimiento</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="requerimiento" name="requerimiento" required>
                                            <label for="requerimiento2">Requerimiento</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="solucion" name="solucion">
                                            <label for="solucion2">Posible solución</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="acuerdo" name="acuerdo">
                                            <label for="acuerdo2">Posible acción</label>
                                        </div>
                                    </div>
                                </div>

                                @if(Auth::user()->rol == 30 )
                                    <input type="hidden" name="rif_emp" id="rif_emp" value="{{ Auth::user()->empresa }}">
                                @else

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
                    url: '{!! route('sistema.requerimientos.data') !!}',
                    method: 'POST'
                },
                columns:
                [
                { data: 'id', name: 'requerimientos.id'  },
                { data: 'empresa', name: 'encuestas.empresa' },
                { data: 'requerimiento', name: 'requerimientos.requerimiento', orderable: false, searchable: false },
                { data: 'solucion', name: 'requerimientos.solucion', orderable: false, searchable: false },
                { data: 'acuerdo', name: 'requerimientos.acuerdo',  orderable: false, searchable: false },
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
                        url:'{!! route('sistema.requerimientos.add') !!}',
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
                    url:'{!! route('sistema.requerimientos.find') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {
                        $.each(data, function(i, item) {

                            $("#id_rq").val(item.id);
                            $("#rif_emp2").val(item.rif_emp);
                            $("#requerimiento2").val(item.requerimiento);
                            $("#solucion2").val(item.solucion);
                            $("#acuerdo2").val(item.acuerdo);
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
                        url:'{!! route('sistema.requerimientos.upd') !!}',
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
                        url:'{!! route('sistema.requerimientos.del') !!}',
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