@extends('layouts.master')

@section('title')
    .:: Usuarios ::.
@endsection

@section('styles')
   <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/DataTables/jquery.dataTables.css') }}" />
   <!--<link href="{{ URL::to('assets/js/libs/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">-->
   <link href="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/css/responsive.dataTables.css') }}" rel="stylesheet">
   <link href="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/css/responsive.bootstrap.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/jquery-ui/jquery-ui-theme.css?1423393666') }}" />
    <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/fileuploader/uploadfile.css') }}" />
    <style>
        
        table{
            width: 100% !important;
        }
    </style>
@endsection

@section('section-header')
    Usuarios
@endsection

@section('content')
    <div class="row">

        <div class="col-lg-12">
            <button type="button" class="btn ink-reaction btn-floating-action btn-sm btn-primary pull-right" id="btnAddUsu" title="Agregar registro">
                <i class="fa fa-plus-square"></i>
            </button>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dt_usuarios" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="sort-numeric">ID</th>
                        <th class="sort-alpha">Nombre</th>
                        <th class="sort-alpha">Email</th>
                        <th class="sort-alpha">Usuario</th>
                        <th class="sort-alpha">Rol</th>
                        <th class="sort-alpha">Activo</th>
                        <th class="sort-alpha">&nbsp;</th>
                    </tr>
                    </thead>
                </table>
            </div><!--end .table-responsive -->
        </div><!--end .col -->
    </div><!--end .row -->

   

    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="formAddUsu" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form-validate" role="form" id="addUsu" novalidate >
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Agregar Usuario</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nom" name="nom" required>
                                            <label for="nom">Nombre (si es una empresa deberia ser el nombre de la misma)</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email" required>
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="usu" name="usu" required>
                                            <label for="usu">Usuario (si es una empresa debe ser el rif (Ej j000000000))</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="rol" name="rol" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                @foreach($rol as $r)
                                                    <option value="{{ $r->id_acceso }}">{{ $r->descripcion }}</option>
                                                @endforeach
                                            </select>
                                            <label for="rol">Rol</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="act" name="act" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="0">NO</option>
                                                <option value="1">SI</option>
                                            </select>
                                            <label for="act">Activo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="rif" name="rif" data-inputmask="'mask': 'R-99999999-9'">
                                            <label for="rif">Empresa RIF</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cnd" name="cnd">
                                            <label for="cnd">Condición</label>
                                        </div>
                                    </div>
                                </div>



                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnAddUsuc">Guardar</button>
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
    <div class="modal fade" id="formActUsu" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form-validate" role="form" id="actUsu" novalidate >
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <input type="hidden" name="id_usu" id='id_usu'>
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Actualizar Usuario</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nom2" name="nom" required>
                                            <label for="nom2">Nombre</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email2" name="email" required>
                                            <label for="email2">Email</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="usu2" name="usu" required>
                                            <label for="usu2">Usuario</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="rol2" name="rol" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                @foreach($rol as $r)
                                                    <option value="{{ $r->id_acceso }}">{{ $r->descripcion }}</option>
                                                @endforeach
                                            </select>
                                            <label for="rol2">Rol</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="act2" name="act" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="0">NO</option>
                                                <option value="1">SI</option>
                                            </select>
                                            <label for="act2">Activo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="rif2" name="rif" data-inputmask="'mask': 'R-99999999-9'">
                                            <label for="rif2">Empresa RIF</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cnd2" name="cnd">
                                            <label for="cnd2">Condición</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnActUsuc">Actualizar</button>
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
    <script src="{{ URL::to('assets/js/libs/jquery-ui/jquery-ui.min.js') }}"></script>
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
            $(":input").inputmask();
            table = $('#dt_usuarios').DataTable({
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
                ajax: '{!! route('sistema.usuarios.data') !!}',
                columns: [
                    { data: 'id', name: 'users.id' },
                    { data: 'nombre', name: 'users.nombre' },
                    { data: 'email', name: 'users.email' },
                    { data: 'user', name: 'users.user' },
                    { data: 'nrol', name: 'roles.descripcion' },
                    { data: 'status', name: 'status' },
                    { data: 'accion', name: 'accion', orderable: false, searchable: false }
                ]
            });

            $("#btnAddUsu").click(function(){
                $("#AddUsu").clearForm();
                $("#formAddUsu").modal('show');
            })

            var fAddUsu = $("#addUsu");
            fAddUsu.validate();
            $('#btnAddUsuc').click(function(){
                if(fAddUsu.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.usuarios.add') !!}',
                        data: fAddUsu.serialize(),
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                table.ajax.reload( null, false );
                                fAddUsu.clearForm();
                                $("#formAddUsu").modal('hide');
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                }
            })

            findUpdateUsu = function(id){
                $.ajax({
                    type: "POST",
                    url:'{!! route('sistema.usuarios.find') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {
                        $.each(data, function(i, item) {
                            $("#id_usu").val(item.id);
                            $("#nom2").val(item.nombre);
                            $("#email2").val(item.email);
                            $("#usu2").val(item.user);
                            $("#rif2").val(item.empresa);
                            $("#cnd2").val(item.cnd);
                            $('#rol2').append($('<option>').text(item.nrol).attr({value: item.rol,selected: "selected"}));
                            act = (item.id_status == 0 )?  'NO':'SI';
                            $('#act2').append($('<option>').text(act).attr({value: item.status,selected: "selected"}));
                        })
                        $("#formActUsu").modal('show');
                    }
                });

            }



            var fActUsu = $("#actUsu");
            fActUsu.validate();
            $('#btnActUsuc').click(function(){
                if(fActUsu.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.usuarios.upd') !!}',
                        data: fActUsu.serialize(),
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                table.ajax.reload( null, false );
                                fActUsu.clearForm();
                                $("#formActUsu").modal('hide');
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                }
            })


            $('#formActUsu').on('hidden.bs.modal', function (e) {
                $("#rol2 option:last, #act2 option:last").remove();
                fActUsu.clearForm();
            })


            deleteUsu = function(id){

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
                        url:'{!! route('sistema.usuarios.del') !!}',
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

            resetClaveUsu = function(id){

                swal({
                    title: "¿Esta seguro que quiere resetear la clave de este usuario?",
                    text: "Esta acción no puede ser desecha",
                    type: "warning",
                    cancelButtonText: "No",
                    showCancelButton: true,
                    confirmButtonText: "Si, estoy seguro",
                    reverseButtons: true
                }).then(function (text) {
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.usuarios.res') !!}',
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

            actDesUsu = function(id){
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
                        url:'{!! route("sistema.usuarios.ades") !!}',
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