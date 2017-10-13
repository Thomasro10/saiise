@extends('layouts.master')

@section('title')
    .:: Evaluación económico-social ::.
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
    Evaluación económico-social
@endsection

@section('content')
    @if( Auth::user()->rol != 3 )
    <!--<div class="row">
        <div class="col-lg-12">
            <button type="button" class="btn ink-reaction btn-floating-action btn-sm btn-primary pull-right" id="btnAddEmp" title="Agregar registro">
                <i class="fa fa-plus-square"></i>
            </button>
        </div>
    </div>-->
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
                        <th class="sort-numeric" width="5%">ID</th>
                        <th class="sort-alpha" width="10%">Fecha solicitud</th>
                        <th class="sort-alpha" width="10%">RIF</th>
                        <th class="sort-alpha" width="30%">Empresa</th>
                        <th class="sort-alpha">Objeto solicitud</th>
                        <th class="sort-alpha" width="30%">Objeto proyecto</th>
                        <th class="sort-alpha">Observación</th>
                        <th class="sort-alpha" width="15%">&nbsp;</th>
                    </tr>
                    </thead>
                </table>
            </div><!--end .table-responsive -->
        </div><!--end .col -->
    </div><!--end .row -->

    <!-- BEGIN SIMPLE MODAL MARKUP -->
    <div class="modal fade" id="detalleEvaEconomica" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
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
                            <header>Detalle Evaluación Económico-social</header>
                        </div><!--end .card-head -->
                        <div class="card-body style-default-bright">
                            <div id="divEvaEcoDet"></div>
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
                        <input type="hidden" name="id_evaeconomica" id="id_evaeconomica">
                        <input type="hidden" name="id_sol" id="id_sol">
                        <input type="hidden" name="responsable" id="responsable">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Evaluación Económico-social</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" required>
                                            <label for="fecha">Fecha</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="justificacion" name="justificacion" class="form-control objeto" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="justificacion">Tiene justificación de proyecto</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="emercado" name="emercado" class="form-control objeto" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="emercado">Tiene estudio de mercado</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="pinversion" name="pinversion" class="form-control objeto" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="pinversion">Tiene plan de inversión, pto. de equilibrio</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="fcaja" name="fcaja" class="form-control objeto" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="fcaja">Tiene flujo de caja proyectado</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="cuae" name="cuae" class="form-control objeto" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="cuae">Tiene CUAE (Costo unitario)</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="van" name="van" class="form-control objeto" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="van">Tiene VAN (valor actual neto)</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="tir" name="tir" class="form-control objeto" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="tir">Tiene TIR (tasa interna de retorno)</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="observacion" name="observacion" required value="SIN OBSERVACION">
                                            <label for="observacion">Observación</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select id="verificado" name="verificado" class="form-control objeto" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="verificado">Evaluado / Verificado</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div id="div_responsable"></div>
                                            <label for="responsable">Asignado a</label>
                                        </div>
                                    </div>
                                </div>
                                <!--   -->

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
            table = $('#dt_emp').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
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
                    url: '{!! route('sistema.eproyecto.economica.data') !!}',
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
                { data: 'empresa', name: 'empresas.empresa' },
                { data: 'objeto', name: 'solicitudes.objeto', orderable: false, searchable: false, visible: false  },
                { data: 'obj_proyecto', name: 'solicitudes.obj_proyecto', "width": "40%"},
                { data: 'observacion', name: 'solicitudes.observacion', orderable: false, searchable: false, visible: false  },
                { data: 'accion', name: 'accion', orderable: false, searchable: false }
                ]
            });

           /****************************************************************************************************************/

           addEvaEconomica= function(id, ced, nom){
               $.ajax({
                   type: "POST",
                   url:'{!! route('sistema.eproyecto.economica.find') !!}',
                   data: {"_token": "{{ csrf_token() }}", "id": id},
                   success: function( data ) {
                       if(data.sol_id != 0){
                           if(data.msj != '0' ){
                               swal(data.msj, "", "info");
                           }
                           else{
                               $.each(data.info, function(i, item) {
                                   $("#id_evaeconomica").val(item.id);
                                   $("#id_sol").val(item.sol_id);
                                   $("#fecha").val(item.fecha);

                                   $('#justificacion').append($('<option>').text(item.justificacion).attr({value: item.justificacion, selected: "selected"}));
                                   $('#emercado').append($('<option>').text(item.emercado).attr({value: item.emercado, selected: "selected"}));
                                   $('#pinversion').append($('<option>').text(item.pinversion).attr({value: item.pinversion, selected: "selected"}));
                                   $('#fcaja').append($('<option>').text(item.fcaja).attr({value: item.fcaja, selected: "selected"}));
                                   $('#cuae').append($('<option>').text(item.cuae).attr({value: item.cuae, selected: "selected"}));
                                   $('#van').append($('<option>').text(item.van).attr({value: item.van, selected: "selected"}));
                                   $('#tir').append($('<option>').text(item.tir).attr({value: item.tir, selected: "selected"}));
                                   $('#responsable').val(ced);
                                   $('#div_responsable').html(nom);
                                   $('#verificado').append($('<option>').text(item.verificado).attr({value: item.verificado, selected: "selected"}));
                                   $("#observacion").text(item.observacion).val(item.observacion);
                               })
                               $('#formAddEmp').modal('show');
                           }

                       }
                       else{
                           $("#id_sol").val(id);
                           $('#responsable').val(ced);
                           $('#div_responsable').html(nom);
                           $('#formAddEmp').modal('show');
                       };
                   }
               });

           }

           var fAddEmp = $("#addEmp");
           fAddEmp.validate();
           $('#btnAddOfic').click(function(){
               if(fAddEmp.valid()){
                   $.ajax({
                       type: "POST",
                       url:'{!! route('sistema.eproyecto.economica.add') !!}',
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

           $('#formAddEmp').on('hidden.bs.modal', function (e) {
               if($('#id_evaeconomica').val() != ''){
                   $("#justificacion option:last, #emercado option:last, #pinversion option:last, #fcaja option:last, #cuae option:last, #van option:last, #tir option:last, #responsable option:last, #verificado option:last").remove();
                   $('#id_evaeconomica').val('');
               }
               fAddEmp.clearForm();
               $("#observacion").val('SIN OBSERVACION');
           })

           viewEvaEconomica= function(id){
               $.ajax({
                   type: "POST",
                   url:'{!! route('sistema.eproyecto.economica.view') !!}',
                   data: {"_token": "{{ csrf_token() }}", "id": id},
                   success: function( data ) {
                       if(data.sol_id != 0){
                           if(data.msj != '0' ){
                               swal(data.msj, "", "info");
                           }
                           else{
                               $.each(data.info, function(i, item) {

                                   html = "<div class='row'>" +
                                       "<div class='col-md-6'>Fecha de comienzo de la evaluación: <strong class='text-ultra-bold'>"+item.fecha+"</strong></div>" +
                                       "<div class='col-md-6'>Fecha de actualización de la evaluación: <strong class='text-ultra-bold'>"+item.actualizacion+"</strong></div>" +
                                       "</div>"+
                                       "<div class='row'>" +
                                       "<div class='col-md-4'>Justificación de proyecto: <strong class='text-ultra-bold'>"+item.justificacion+"</strong></div>" +
                                       "<div class='col-md-4'>Estudio de mercado: <strong class='text-ultra-bold'>"+item.emercado+"</strong></div>" +
                                       "<div class='col-md-4'>Plan de inversión, pto. de equilibrio: <strong class='text-ultra-bold'>"+item.pinversion+"</strong></div>" +
                                       "</div>"+
                                       "<div class='row'>" +
                                       "<div class='col-md-6'>Flujo de caja proyectado: <strong class='text-ultra-bold'>"+item.fcaja+"</strong></div>" +
                                       "<div class='col-md-6'>CUAE (Costo unitario): <strong class='text-ultra-bold'>"+item.cuae+"</strong></div>" +
                                       "</div>"+
                                       "<div class='row'>" +
                                       "<div class='col-md-6'>VAN (valor actual neto): <strong class='text-ultra-bold'>"+item.van+"</strong></div>" +
                                       "<div class='col-md-6'>TIR (tasa interna de retorno): <strong class='text-ultra-bold'>"+item.tir+"</strong></div>" +
                                       "</div>"+
                                       "<div class='row'>" +
                                       "<div class='col-md-12'>Observación: <strong class='text-ultra-bold'>"+item.observacion+"</strong></div>" +
                                       "</div>"+
                                       "<div class='row'>" +
                                       "<div class='col-md-6'>Verificado: <strong class='text-ultra-bold'>"+item.verificado+"</strong></div>" +
                                       "<div class='col-md-6'>Responsable: <strong class='text-ultra-bold'>"+item.nombre+"</strong></div>" +
                                       "</div>";

                                   $('#divEvaEcoDet').empty().html(html);

                               })
                               $('#detalleEvaEconomica').modal('show');
                           }

                       }
                   }
               });
           }

           $('#detalleEvaEconomica').on('hidden.bs.modal', function (e) {
               $('#divEvaEcoDet').empty();
           })

           delEvaEconomica = function(id){
               swal({
                   title: "¿Esta seguro que quiere resetear este registro?",
                   text: "Esta acción no puede ser desecha",
                   type: "warning",
                   cancelButtonText: "No",
                   showCancelButton: true,
                   confirmButtonText: "Si, estoy seguro",
                   reverseButtons: true
               }).then(function (text) {
                   $.ajax({
                       type: "POST",
                       url:'{!! route('sistema.eproyecto.economica.del') !!}',
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