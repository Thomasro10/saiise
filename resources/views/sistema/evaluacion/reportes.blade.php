@extends('layouts.master')

@section('title')
    .:: Evaluación Reportes  ::.
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

        .subtotal{
            font-size: 12px !important;
            font-weight: bold !important;
            color: #ffffff !important;
            background-color:#48288b !important;
        }




    </style>
@endsection

@section('section-header')
    Reportes Evaluación de proyectos
@endsection

@section('content')


    <div class="row">
        <div class="col-lg-3">
            <form class="form form-validate" method="post" role="form" id="formfpsa" novalidate >
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                <div class="card">
                    <div class="card-head style-primary">
                        <header>Proyectos sin aprobación</header>
                    </div>
                    <div class="card-body">
                        <em class="text-caption">Criterio: fecha de asignación de responsable</em>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fpsa_inicio" name="fecha_inicio" required >
                                    <label for="fpsa_inicio">Fecha inicio</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fpsa_fin" name="fecha_fin" required >
                                    <label for="fpsa_fin">Fecha fin</label>
                                </div>
                            </div>
                        </div>
                        <!--   -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnBqdfpsa">Buscar</button>
                    </div>
                </div><!--end .card -->
            </form>
        </div>
        <div class="col-lg-3">
            <form class="form form-validate" method="post" role="form" id="formfpca" novalidate >
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                <div class="card">
                    <div class="card-head style-primary">
                        <header>Proyectos con aprobación</header>
                    </div>
                    <div class="card-body">
                        <em class="text-caption">Criterio: fecha de asignación de responsable</em>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fpca_inicio" name="fecha_inicio" required >
                                    <label for="fpca_inicio">Fecha inicio</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fpca_fin" name="fecha_fin" required >
                                    <label for="fpca_fin">Fecha fin</label>
                                </div>
                            </div>
                        </div>
                        <!--   -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnBqdfpca">Buscar</button>
                    </div>
                </div><!--end .card-->
            </form>
        </div>
        <div class="col-lg-6">
            <form class="form form-validate" method="post" role="form" id="formPft" novalidate >
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                <div class="card">
                    <div class="card-head style-primary">
                        <header>Tiempo por fase (Proyectos)</header>
                    </div>
                    <div class="card-body">
                        <em class="text-caption">Criterio: fecha de asignación de responsable</em>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="ftf_inicio" name="fecha_inicio" required >
                                    <label for="ftf_inicio">Fecha inicio</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="ftf_fin" name="fecha_fin" required >
                                    <label for="ftf_fin">Fecha fin</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select id="eva_tf" name="eva" class="form-control objeto" required>
                                        <option value="">&nbsp;</option>
                                        <option value="LEGAL">LEGAL</option>
                                        <option value="ECONOMICO-SOCIAL">ECONOMICO-SOCIAL</option>
                                        <option value="FINANCIERA">FINANCIERA</option>
                                        <option value="INGENIERIA">INGENIERIA DE DISEÑO</option>
                                    </select>
                                    <label for="eva_tf">Evaluación</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select id="ver" name="ver" class="form-control objeto" required>
                                        <option value="">&nbsp;</option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                    <label for="ver">Verificados</label>
                                </div>
                            </div>
                        </div>
                        <!--   -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnBqdPtf">Buscar</button>
                    </div>
                </div><!--end .card -->
            </form>
        </div>
        <!--<div class="col-lg-3">
            <form class="form form-validate" method="post" role="form" id="formAvance" novalidate >
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                <div class="card">
                    <div class="card-head style-primary">
                        <header>Avance</header>
                    </div>
                    <div class="card-body">
                        <em class="text-caption">Criterio: fecha de asignación de responsable</em>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fea_inicio" name="fecha_inicio" required >
                                    <label for="fea_inicio">Fecha inicio</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fea_fin" name="fecha_fin" required >
                                    <label for="fea_fin">Fecha fin</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnBqdAva">Buscar</button>
                    </div>
                </div>
            </form>
        </div>-->
    </div>








    <!-- BEGIN SIMPLE MODAL MARKUP -->
    <div class="modal fade" id="detalleEvaNoApro" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
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
                            <header>Proyectos no verificados por evaluación (<span id="fecha_psa"></span> )</header>
                        </div><!--end .card-head -->
                        <div class="card-body style-default-bright">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table id="dt_EvaNoApro" class="table table-striped table-hover text-sm">
                                            <thead>
                                            <tr>
                                                <th class="sort-alpha">id</th>
                                                <th class="sort-alpha">Evaluación</th>
                                                <th class="sort-alpha">Cantidad</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div><!--end .table-responsive-->
                                </div><!--end .col-->
                            </div><!--end .row -->

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

    <!-- BEGIN SIMPLE MODAL MARKUP -->
    <div class="modal fade" id="detalleEvaApro" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
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
                            <header>Proyectos verificados por evaluación (<span id="fecha_pca"></span> )</header>
                        </div><!--end .card-head -->
                        <div class="card-body style-default-bright">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table id="dt_EvaApro" class="table table-striped table-hover text-sm">
                                            <thead>
                                            <tr>
                                                <th class="sort-alpha">id</th>
                                                <th class="sort-alpha">Evaluación</th>
                                                <th class="sort-alpha">Cantidad</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div><!--end .table-responsive-->
                                </div><!--end .col-->
                            </div><!--end .row -->

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

    <!-- BEGIN SIMPLE MODAL MARKUP -->
    <div class="modal fade" id="detalleEvaTF" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
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
                            <header>Tiempo en evaluación (<span id="ttloEvaTFLegal"></span> )</header>
                        </div><!--end .card-head -->
                        <div class="card-body style-default-bright">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table id="dt_ttf" class="table table-striped table-hover text-sm">
                                            <thead>
                                            <tr>
                                                <th class="sort-alpha">id</th>
                                                <th class="sort-alpha">Fecha solicitud</th>
                                                <th class="sort-alpha">Empresa</th>
                                                <th class="sort-alpha">Objeto proyecto</th>
                                                <th class="sort-alpha">Responsable</th>
                                                <th class="sort-alpha">Tiempo en fase</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div><!--end .table-responsive-->
                                </div><!--end .col-->
                            </div><!--end .row -->

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

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ Session::token() }}'
                }
            });

            var ffpsa = $("#formfpsa");
            ffpsa.validate();
            $('#btnBqdfpsa').click(function(){
                fi = $("#fpsa_inicio").val().split('-');
                ff = $("#fpsa_fin").val().split('-');
                if(ffpsa.valid()){

                    $("#fecha_psa").html(fi[2]+'/'+fi[1]+'/'+fi[0]+' al '+ff[2]+'/'+ff[1]+'/'+ff[0])
                    dt_fpsa = c_fpsa_fpca('{!! route('sistema.eproyecto.reportes.dataEvaModSA') !!}?f_ini='+$("#fpsa_inicio").val()+'&f_fin='+$("#fpsa_fin").val()+'&cnd=psa&rand='+Math.random() , 'dt_EvaNoApro');
                    $("#detalleEvaNoApro").modal('show');
                }
            })

            var ffpca = $("#formfpca");
            ffpca.validate();
            $('#btnBqdfpca').click(function(){
                fi = $("#fpca_inicio").val().split('-');
                ff = $("#fpca_fin").val().split('-');
                if(ffpca.valid()){

                    $("#fecha_pca").html(fi[2]+'/'+fi[1]+'/'+fi[0]+' al '+ff[2]+'/'+ff[1]+'/'+ff[0])
                    dt_fpca = c_fpsa_fpca('{!! route('sistema.eproyecto.reportes.dataEvaModCA') !!}?f_ini='+$("#fpca_inicio").val()+'&f_fin='+$("#fpca_fin").val()+'&cnd=pca&rand='+Math.random() , 'dt_EvaApro');
                    $("#detalleEvaApro").modal('show');
                }
            })

            c_fpsa_fpca = function (url, tid) {
                cdia = $('#'+tid).DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    paging: false,
                    destroy: true,
                    order: [[0, "asc"]],
                    dom: 'Brtip',
                    buttons: [
                        {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o"></i>',titleAttr: 'Excel', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs'},
                        {extend:'pdfHtml5',text:'<i class="fa fa-file-pdf-o"></i>',titleAttr: 'PDF', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs', orientation: 'landscape', pageSize: 'LEGAL'},
                    ],
                    language: {
                        url: '{{ URL::to('assets/js/libs/DataTables/spanish.json') }}'
                    },
                    ajax: url,
                    columns: [
                        {data: 'id', name: 'id', orderable: false, searchable: false },
                        {data: 'eva', name: 'eva', orderable: false, searchable: false },
                        {data: 'cant', name: 'cant', orderable: false, searchable: false }
                    ]
                });
                return cdia;
            }

            var ffft = $("#formPft");
            ffft.validate();
            $('#btnBqdPtf').click(function(){
                fi = $("#ftf_inicio").val().split('-');
                ff = $("#ftf_fin").val().split('-');

                switch ($('#eva_tf').val()){
                    case "LEGAL":
                        url = '{!! route('sistema.eproyecto.reportes.dataEvaTFLegal') !!}?f_ini='+$("#ftf_inicio").val()+'&f_fin='+$("#ftf_fin").val()+'&ver='+$("#ver").val()
                    break;
                    case "ECONOMICO-SOCIAL":
                        url = '{!! route('sistema.eproyecto.reportes.dataEvaTFEconomica') !!}?f_ini='+$("#ftf_inicio").val()+'&f_fin='+$("#ftf_fin").val()+'&ver='+$("#ver").val()
                    break;
                    case "FINANCIERA":
                        url = '{!! route('sistema.eproyecto.reportes.dataEvaTFFinanciera') !!}?f_ini='+$("#ftf_inicio").val()+'&f_fin='+$("#ftf_fin").val()+'&ver='+$("#ver").val()
                    break;
                    case "INGENIERIA":
                        url = '{!! route('sistema.eproyecto.reportes.dataEvaTFIngenieria') !!}?f_ini='+$("#ftf_inicio").val()+'&f_fin='+$("#ftf_fin").val()+'&ver='+$("#ver").val()
                    break;
                }

                if(ffft.valid()){
                    $("#ttloEvaTFLegal").empty().html(fi[2]+'/'+fi[1]+'/'+fi[0]+' al '+ff[2]+'/'+ff[1]+'/'+ff[0]+' - Evaluacion: '+$('#eva_tf').val()+' - Verificado: '+$("#ver").val())
                    dt_ftf = c_ftf( url , 'dt_ttf');
                    $("#detalleEvaTF").modal('show');
                }
            })

            c_ftf = function (url, tid) {
                cdia = $('#'+tid).DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    paging: false,
                    destroy: true,
                    order: [[0, "asc"]],
                    dom: 'Brtip',
                    buttons: [
                        {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o"></i>',titleAttr: 'Excel', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs'},
                        {extend:'pdfHtml5',text:'<i class="fa fa-file-pdf-o"></i>',titleAttr: 'PDF', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs', orientation: 'landscape', pageSize: 'LEGAL'},
                    ],
                    language: {
                        url: '{{ URL::to('assets/js/libs/DataTables/spanish.json') }}'
                    },
                    ajax: url,
                    columns: [
                        {data: 'id', name: 'id' },
                        {data: 'fecha', name: 'fecha', orderable: false, searchable: false },
                        {data: 'empresa', name: 'empresa', orderable: false, searchable: false },
                        {data: 'obj_proyecto', name: 'obj_proyecto', orderable: false, searchable: false },
                        {data: 'nombre', name: 'nombre', orderable: false, searchable: false },
                        {data: 't_fase', name: 't_fase', orderable: false, searchable: false }
                    ]
                });
                return cdia;
            }

        });
    </script>
@endsection