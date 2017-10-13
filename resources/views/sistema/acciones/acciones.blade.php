@extends('layouts.master')

@section('title')
    .:: Acciones ::.
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
    Acciones
@endsection

@section('content')

   <!-- <div class="row">

        <div class="col-lg-12">
            <button type="button" class="btn ink-reaction btn-floating-action btn-sm btn-primary pull-right" id="btnAddEmp" title="Agregar registro">
                <i class="fa fa-plus-square"></i>
            </button>
        </div>

    </div>-->

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
                        <th class="sort-numeric">Monto Bs</th>
                        <th class="sort-numeric">Monto USD</th>
                        <th class="sort-alpha">Para</th>
                        <th class="sort-alpha">Otro objeto solicitud</th>
                        <th class="sort-alpha" width="10%">&nbsp;</th>
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
                                <header>Actualizar acciones</header>
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
                                <header>Agregar acciones</header>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="id_sol" id="id_sol">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="solicitud" name="solicitud" onfocus="getSolicitud('solicitud', 'id_sol', '{!! route('sistema.getSolicitud') !!}')" required >
                                            <label for="solicitud">Solicitud (Teclea 1 caracter para comenzar la busqueda (Id, fecha, Empresa, objeto solicitud u origen solicitud))</label>
                                        </div>
                                    </div>
                                </div>


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
   <div class="modal fade" id="accAddForm" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
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
                           <header>Agregar acción</header>
                       </div><!--end .card-head -->
                       <div class="card-body style-default-bright">
                           <div id="divFormAcc"></div>


                       </div><!--end .card-body -->
                   </div><!--end .card -->
               </div>
               <!--<div class="modal-footer">
                   <button type="button" class="btn ink-reaction btn-primary" data-dismiss="modal">Aceptar</button>
               </div>-->

           </div><!-- /.modal-content -->
       </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->
   <!-- END SIMPLE MODAL MARKUP -->

   <!-- BEGIN SIMPLE MODAL MARKUP -->
   <div class="modal fade" id="accVerForm" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
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
                           <header>Acciones</header>
                       </div><!--end .card-head -->
                       <div class="card-body style-default-bright">
                           <div id="divVerAcc"></div>


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
                    url: '{!! route('sistema.acciones.data') !!}',
                    data: function (d) {
                            d.fecha_inicio = $('input[name=fecha_inicio]').val();
                            d.fecha_fin = $('input[name=fecha_fin]').val();
                    },
                    method: 'POST'
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
                            { data: 'fin_montobs', name: 'solicitudes.fin_montobs', orderable: false, searchable: false, visible: false  },
                            { data: 'fin_montousd', name: 'solicitudes.fin_montousd', orderable: false, searchable: false, visible: false  },
                            { data: 'fin_para', name: 'solicitudes.fin_para', orderable: false, searchable: false, visible: false  },
                            { data: 'sol_otros', name: 'solicitudes.sol_otros', orderable: false, searchable: false, visible: false  },
                            { data: 'accion', name: 'accion', orderable: false, searchable: false }
                        ]/*,
                "fnCreatedRow": function(nRow, aData, iDataIndex) {
                    if (aData.acciones > 0) {
                        $('td', nRow).addClass('text-primary-dark');
                    }
                }*/
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


            addAccion = function(id){
                $.ajax({
                    type: "POST",
                    url:'{!! route('sistema.acciones.verform') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {
                        $("#divFormAcc").empty().html(data);
                        $("#accAddForm").modal('show');
                    }
                });
            }

        });

        function verAccion(id){
            $.ajax({
                type: "POST",
                url:'{!! route('sistema.acciones.veracciones') !!}',
                data: {"_token": "{{ csrf_token() }}", "id": id},
                success: function( data ) {
                    $("#divVerAcc").empty().html(data);
                    $("#accVerForm").modal('show');
                }
            });
        }
        function recargaAccion(id){
            $.ajax({
                type: "POST",
                url:'{!! route('sistema.acciones.veracciones') !!}',
                data: {"_token": "{{ csrf_token() }}", "id": id},
                success: function( data ) {
                    $("#divVerAcc").empty().html(data);
                }
            });
        }
    </script>
@endsection