@extends('layouts.master')

@section('title')
    .:: Logs ::.
@endsection

@section('styles')
   <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/DataTables/jquery.dataTables.css') }}" />
   <!--<link href="{{ URL::to('assets/js/libs/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">-->
   <link href="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/css/responsive.dataTables.css') }}" rel="stylesheet">
   <link href="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/css/responsive.bootstrap.css') }}" rel="stylesheet">
    <!--<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/jquery-ui/jquery-ui-theme.css?1423393666') }}" />-->
    <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/fileuploader/uploadfile.css') }}" />
    <style>
        
        table{
            width: 100% !important;
        }
    </style>
@endsection

@section('section-header')
    Logs
@endsection

@section('content')


    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dt_usuarios" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="sort-numeric">ID</th>
                        <th class="sort-alpha">Usuario</th>
                        <th class="sort-alpha">Módulo</th>
                        <th class="sort-alpha">Acción</th>
                        <th class="sort-alpha">RIF Empresa</th>
                        <th class="sort-alpha">Fecha</th>
                    </tr>
                    </thead>
                </table>
            </div><!--end .table-responsive -->
        </div><!--end .col -->
    </div><!--end .row -->

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
   <!-- <script src="{{ URL::to('assets/js/libs/jquery-ui/jquery-ui.min.js') }}"></script>-->
    <script src="{{ URL::to('assets/js/libs/inputmask/jquery.inputmask.bundle.min.js') }}"></script>




    <script>
        $(function() {
            table = $('#dt_usuarios').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthMenu: [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "All"]],
                order: [[ 0, "desc" ]],
               dom: 'Blfrtip',
                buttons: [
                    {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o"></i>',titleAttr: 'Excel', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs'},
                    {extend:'pdfHtml5',text:'<i class="fa fa-file-pdf-o"></i>',titleAttr: 'PDF', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs', pageSize: 'LEGAL'},
                    {text:'<i class="fa fa-refresh"></i>',titleAttr: 'Actualizar', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs',
                        action: function (e, dt, node, config) {
                           table.ajax.reload();
                        }
                    },
                    {text: '<i class="fa fa-calendar"></i>',className: 'btn ink-reaction btn-floating-action btn-primary btn-xs',titleAttr: 'Busqueda intérvalo de fecha', action: function ( e, dt, node, config ){
                        $( '#bsqIntFecha' ).modal('show');
                       }
                    }
                ],
                language: {
                    url: '{{ URL::to('assets/js/libs/DataTables/spanish.json') }}'
                },
                ajax: {
                    url: '{!! route('sistema.logs.data') !!}',
                    data: function (d) {
                        d.fecha_inicio = $('input[name=fecha_inicio]').val();
                        d.fecha_fin = $('input[name=fecha_fin]').val();
                    }
                    //method: 'POST'
                },
                columns: [
                    { data: 'id', name: 'logs.id' },
                    { data: 'usuario', name: 'logs.usuario' },
                    { data: 'modulo', name: 'logs.modulo' },
                    { data: 'accion', name: 'logs.accion' },
                    { data: 'empresa', name: 'logs.empresa' },
                    { data: 'fecha', name: 'fecha' }
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

        });
    </script>
@endsection