@extends('layouts.master')

@section('title')
    .:: Requerimientos financieros ::.
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
    Requerimientos financieros
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
    @if(Auth::user()->rol == 30 )

       <!-- <div class="row">
            <div class="col-lg-12">
                <h4>En este módulo se guarda la información que tiene que ver con los requerimientos financieros</h4>
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
                        <th class="sort-alpha">Empresa</th>
                        <th class="sort-alpha">Divisas propias</th>
                        <th class="sort-alpha">Propuesta</th>
                        <th class="sort-alpha">Exportar</th>
                        <th class="sort-alpha">Propuesta</th>
                        <th class="sort-alpha">Recursos financieros</th>
                        <th class="sort-alpha">Monto BS</th>
                        <th class="sort-alpha">Monto dolares</th>
                        <th class="sort-alpha">Observación</th>
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
                        <input type="hidden" name="id" id="id_rf">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Actualizar Requerimiento Financiero</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="divpropias2" name="divpropias" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="divpropias2">¿Estaría dispuesto a trabajar con  divisas propias?</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <textarea name="dppropuesta" id="dppropuesta2" class="form-control" rows="2" placeholder="" ></textarea>
                                            <label for="dppropuesta2">Propuesta</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="exportar2" name="exportar" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="exportar2">¿Posee capacidad para exportar?</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <textarea name="expropuesta" id="expropuesta2" class="form-control" rows="2" placeholder="" ></textarea>
                                            <label for="expropuesta2">Propuesta</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="rfinancieros2" name="rfinancieros" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="BOLÍVARES">BOLÍVARES</option>
                                                <option value="DÓLARES">DÓLARES</option>
                                                <option value="AMBOS">AMBOS</option>
                                            </select>
                                            <label for="rfinancieros2">Tipos de recursos financieros</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="montobs2" name="montobs" required>
                                            <label for="montobs2">Monto requerido en bolívares</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="montodiv2" name="montodiv" required>
                                            <label for="montodiv2">Monto requerido en dolares</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="observacion" id="observacion2" class="form-control" rows="2" placeholder="" ></textarea>
                                            <label for="observacion2">Observación</label>
                                        </div>
                                    </div>
                                </div>
                                @if(Auth::user()->rol == 30 )
                                    <input type="hidden" id="rif_emp2" name="rif_emp">
                                @else
                                <input type="hidden" name="rif_emp" id="rif_emp2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="empresa2" name="empresa"   onfocus="getEmpresa('empresa2', 'rif_emp2', '{!! route('sistema.getEmpresa') !!}')" required >
                                            <label for="empresa2">Empresa (Teclea 2 caracteres para comenzar la busqueda (Nombre o RIF))</label>
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
                                <header>Agregar Requerimiento Financiero</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="divpropias" name="divpropias" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="divpropias">¿Estaría dispuesto a trabajar con  divisas propias?</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <textarea name="dppropuesta" id="dppropuesta" class="form-control" rows="2" placeholder="" ></textarea>
                                            <label for="dppropuesta">Propuesta</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="exportar" name="exportar" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="exportar">¿Posee capacidad para exportar?</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <textarea name="expropuesta" id="expropuesta" class="form-control" rows="2" placeholder="" ></textarea>
                                            <label for="expropuesta">Propuesta</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="rfinancieros" name="rfinancieros" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="BOLÍVARES">BOLÍVARES</option>
                                                <option value="DÓLARES">DÓLARES</option>
                                                <option value="AMBOS">AMBOS</option>
                                            </select>
                                            <label for="rfinancieros">Tipos de recursos financieros</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="montobs" name="montobs" required>
                                            <label for="montobs">Monto requerido en bolívares</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="montodiv" name="montodiv" required>
                                            <label for="montodiv">Monto requerido en dolares</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="observacion" id="observacion" class="form-control" rows="2" placeholder="" ></textarea>
                                            <label for="observacion">Observación</label>
                                        </div>
                                    </div>
                                </div>

                            @if(Auth::user()->rol == 30 )
                                <input type="hidden" id="rif_emp" name="rif_emp" value="{{ Auth::user()->empresa }}">
                            @else
                            <input type="hidden" name="rif_emp" id="rif_emp">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="empresa" name="empresa" onfocus="getEmpresa('empresa', 'rif_emp', '{!! route('sistema.getEmpresa') !!}')" required >
                                            <label for="empresa">Empresa (Teclea 2 caracteres para comenzar la busqueda (Nombre o RIF))</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

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
                    url: '{!! route('sistema.finanzas.data') !!}',
                    method: 'POST'
                },
                columns:
                [
                { data: 'id', name: 'rqfinanciamiento.id'  },
                { data: 'empresa', name: 'empresas.empresa' },
                { data: 'divpropias', name: 'rqfinanciamiento.divpropias' },
                { data: 'dppropuesta', name: 'rqfinanciamiento.dppropuesta', orderable: false, searchable: false, visible: false  },
                { data: 'exportar', name: 'rqfinanciamiento.exportar' },
                { data: 'expropuesta', name: 'rqfinanciamiento.expropuesta', orderable: false, searchable: false, visible: false  },
                { data: 'rfinancieros', name: 'rqfinanciamiento.rfinancieros' },
                { data: 'montobs', name: 'rqfinanciamiento.montobs', orderable: false, searchable: false },
                { data: 'montodiv', name: 'rqfinanciamiento.montodiv', orderable: false, searchable: false  },
                { data: 'observacion', name: 'rqfinanciamiento.observacion', orderable: false, searchable: false, visible: false  },
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
                        url:'{!! route('sistema.finanzas.add') !!}',
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
                    url:'{!! route('sistema.finanzas.find') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {
                        $.each(data, function(i, item) {

                            $("#id_rf").val(item.id);
                            $("#rif_emp2").val(item.rif_emp);
                            $("#divpropias2").append($('<option>').text(item.divpropias).attr({value: item.divpropias,selected: "selected"}));
                            $("#dppropuesta2").text(item.dppropuesta);
                            $("#exportar2").append($('<option>').text(item.exportar).attr({value: item.exportar,selected: "selected"}));
                            $("#expropuesta2").text(item.expropuesta);
                            $("#rfinancieros2").append($('<option>').text(item.rfinancieros).attr({value: item.rfinancieros,selected: "selected"}));
                            $("#montobs2").val(item.montobs);
                            $("#montodiv2").val(item.montodiv);
                            $("#observacion2").text(item.observacion);
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
                        url:'{!! route('sistema.finanzas.upd') !!}',
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
                        url:'{!! route('sistema.finanzas.del') !!}',
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