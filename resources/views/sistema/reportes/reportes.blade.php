@extends('layouts.master')

@section('title')
    .:: Reportes ::.
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
    Reportes
@endsection

@section('content')


    <div class="row">
        <div class="col-lg-4">
            <form class="form form-validate" method="post" role="form" id="formEmpAtem" novalidate >
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                <div class="card">
                    <div class="card-head style-primary">
                        <div class="tools">
                            <div class="btn-group">
                                <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                            </div>
                        </div>
                        <header>Empresas Atendidas</header>
                    </div>
                    <div class="card-body">
                        <em class="text-caption">Criterio: fecha de registro de solicitud</em>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fea_inicio" name="fecha_inicio" required >
                                    <label for="fea_inicio">Fecha inicio</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fea_fin" name="fecha_fin" required >
                                    <label for="fea_fin">Fecha fin</label>
                                </div>
                            </div>
                        </div>
                        <!--   -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnBqdEmpAten">Buscar</button>
                    </div>
                </div><!--end .card -->
            </form>
        </div>
        @if (Auth::user()->rol != 5  )
        <div class="col-lg-4">
            <form class="form form-validate" method="post" role="form" id="formAvance" novalidate >
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                <div class="card">
                    <div class="card-head style-primary">
                        <div class="tools">
                            <div class="btn-group">
                                <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                            </div>
                        </div>
                        <header>Avance</header>
                    </div>
                    <div class="card-body">
                        <em class="text-caption">Criterio: fecha de registro de solicitud</em>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fav_inicio" name="fecha_inicio" required >
                                    <label for="fea_inicio">Fecha inicio</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fav_fin" name="fecha_fin" required >
                                    <label for="fea_fin">Fecha fin</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnBqdAva">Buscar</button>
                    </div>
                </div><!--end .card-->
            </form>
        </div>
        @endif
    </div>


    <!-- BEGIN SIMPLE MODAL MARKUP -->
    <div class="modal fade" id="detalleEmpAten" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
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
                            <header>Empresas Atendidas (<span id="ttlo_emp_aten"></span> )</header>
                        </div><!--end .card-head -->
                        <div class="card-body style-default-bright">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table id="dt_emp_aten" class="table table-striped table-hover text-sm">
                                            <thead>
                                            <tr>
                                                <th class="sort-alpha" width="5%">Fecha</th>
                                                <th class="sort-alpha" width="20%">Empresa</th>
                                                <th class="sort-alpha" width="20%">RIF</th>

                                                <th class="sort-alpha">Teléfono de contacto</th>

                                                <th class="sort-alpha">Sector</th>
                                                <th class="sort-alpha">Rubro</th>
                                                <th class="sort-alpha">Convenio</th>

                                                <th class="sort-alpha" width="15%">Atendida por</th>
                                                <th class="sort-alpha">Origen de la solicitud</th>
                                                <th class="sort-alpha">Si es otro, especifique</th>
                                                <th class="sort-alpha" width="20%">Objeto de solucitud</th>
                                                <th class="sort-alpha">Monto en BS (Si aplica)</th>
                                                <th class="sort-alpha">Monto en USD (Si aplica)</th>
                                                <th class="sort-alpha">Para qué? (Si aplica)</th>

                                                <th class="sort-alpha">Banco de preferencia (Si aplica)</th>

                                                <th class="sort-alpha" width="20%">Últ. acción registrada</th>
                                                <th class="sort-alpha" width="20%">Últ. seguimiento registrado</th>
                                                <th class="sort-alpha">Observación</th>

                                                <th class="sort-alpha">Estatus por DGIPI (Si aplica)</th>
                                                <th class="sort-alpha">Fecha de estatus (Si aplica)</th>
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
        <div class="modal fade" id="detalleAvance" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
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
                                <header>Avance (<span id="ttlo_avance"></span> )</header>
                            </div><!--end .card-head -->
                            <div class="card-body style-default-bright">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table id="dt_avance" class="table table-striped table-hover text-sm">
                                                <thead>
                                                <tr>
                                                    <th class="sort-alpha">Atendida por</th>
                                                    <th class="sort-alpha">Empresa</th>
                                                    <th class="sort-alpha">Objeto de solucitud</th>
                                                    <th class="sort-alpha">% de avance</th>
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

            var fBqEmAt = $("#formEmpAtem");
            fBqEmAt.validate();
            $('#btnBqdEmpAten').click(function(){
                fi = $("#fea_inicio").val().split('-');
                ff = $("#fea_fin").val().split('-');
                if(fBqEmAt.valid()){

                    $("#ttlo_emp_aten").html(fi[2]+'/'+fi[1]+'/'+fi[0]+' al '+ff[2]+'/'+ff[1]+'/'+ff[0])
                    dt_rdia = c_emp_aten('{!! route('sistema.reportes.empaten') !!}?f_ini='+$("#fea_inicio").val()+'&f_fin='+$("#fea_fin").val());
                    $("#detalleEmpAten").modal('show');
                }
            })

            c_emp_aten = function (url) {
                cdia = $('#dt_emp_aten').DataTable({
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
                        {data: 'fecha', name: 'fecha', orderable: false, searchable: false },
                        {data: 'empresa', name: 'empresa', orderable: false, searchable: false },
                        {data: 'rif', name: 'rif', orderable: false, searchable: false, visible: false  },

                        {data: 'telf', name: 'telf', orderable: false, searchable: false, visible: false },

                        {data: 'sector', name: 'sector', orderable: false, searchable: false, visible: false  },
                        {data: 'rubro', name: 'rubro', orderable: false, searchable: false, visible: false  },
                        {data: 'convenio', name: 'convenio', orderable: false, searchable: false, visible: false  },

                        {data: 'atendido_por', name: 'atendido_por', orderable: false, searchable: false },
                        {data: 'origen', name: 'origen',  orderable: false, searchable: false, visible: false  },
                        {data: 'ori_especifique', name: 'ori_especifique',  orderable: false, searchable: false, visible: false  },
                        {data: 'objeto', name: 'objeto',  orderable: false, searchable: false },
                        {data: 'fin_montobs', name: 'fin_montobs',  orderable: false, searchable: false, visible: false },
                        {data: 'fin_montousd', name: 'fin_montousd',  orderable: false, searchable: false, visible: false },
                        {data: 'fin_para', name: 'fin_para',  orderable: false, searchable: false, visible: false },

                        {data: 'fin_banco', name: 'fin_banco',  orderable: false, searchable: false, visible: false },

                        {data: 'ult_acc_reg', name: 'ult_acc_reg', orderable: false, searchable: false },
                        {data: 'ult_seg_reg', name: 'ult_seg_reg', orderable: false, searchable: false},
                        {data: 'observacion', name: 'observacion', orderable: false, searchable: false, visible: false },

                        {data: 'status', name: 'status', orderable: false, searchable: false, visible: false },
                        {data: 'fecha_status', name: 'fecha_status', orderable: false, searchable: false, visible: false }
                    ]
                });
                return cdia;
            }


            var fBqAva = $("#formAvance");
            fBqAva.validate();
            $('#btnBqdAva').click(function(){
                fi = $("#fav_inicio").val().split('-');
                ff = $("#fav_fin").val().split('-');
                if(fBqAva.valid()){

                    $("#ttlo_avance").html(fi[2]+'/'+fi[1]+'/'+fi[0]+' al '+ff[2]+'/'+ff[1]+'/'+ff[0])
                    dt_rdia = c_avance('{!! route('sistema.reportes.avance') !!}?f_ini='+$("#fav_inicio").val()+'&f_fin='+$("#fav_fin").val(),$("#fav_inicio").val(), $("#fav_fin").val());
                    $("#detalleAvance").modal('show');
                }
            })


            c_avance = function (url, f1, f2) {
                cdia = $('#dt_avance').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    paging: false,
                    destroy: true,
                    //order: [[0, "asc"]],
                    dom: 'Brtip',
                    buttons: [
                        {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o"></i>',titleAttr: 'Excel', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs'},
                        {extend:'pdfHtml5',text:'<i class="fa fa-file-pdf-o"></i>',titleAttr: 'PDF', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs', orientation: 'landscape', pageSize: 'LEGAL'},
                        {text: '<i class="fa fa-pie-chart"></i>',className: 'btn ink-reaction btn-floating-action btn-primary btn-xs',titleAttr: 'ver gráficos', action: function ( e, dt, node, config ){
                            var strWindowFeatures = "location=no, menubar=no, titlebar=no, resizable=yes, toolbar=no, menubar=no, width="+$( window ).width()+", height="+$( window ).height();
                            window.open("{!! route('sistema.reportes.graficos') !!}?f1="+f1+'&f2='+f2 , "Gráficos Intervalo", strWindowFeatures);
                         }
                        }
                    ],
                    language: {
                        url: '{{ URL::to('assets/js/libs/DataTables/spanish.json') }}'
                    },
                    ajax: url,
                    columns: [
                        {data: 'atendido_por', name: 'atendido_por', orderable: false, searchable: false },
                        {data: 'empresa', name: 'empresa', orderable: false, searchable: false },
                        {data: 'objeto', name: 'objeto',  orderable: false, searchable: false },
                        {data: 'promedio', name: 'promedio',  orderable: false, searchable: false },
                    ],
                    "createdRow": function( row, data, dataIndex ) {

                        if (data['empresa'] == "") {
                            $(row).addClass('subtotal');

                        }
                    }
                });
                return cdia;
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

        });
    </script>
@endsection