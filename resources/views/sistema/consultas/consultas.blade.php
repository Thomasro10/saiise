@extends('layouts.master')

@section('title')
    .:: Consultas ::.
@endsection

@section('styles')
  <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/DataTables/jquery.dataTables.css') }}" />
    <!--<link href="{{ URL::to('assets/js/libs/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">-->
   <link href="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/css/responsive.dataTables.css') }}" rel="stylesheet">
   <link href="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/css/responsive.bootstrap.css') }}" rel="stylesheet">
   <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/jquery-ui/jquery-ui-theme.css?1423393666') }}" />
   <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/fileuploader/uploadfile.css') }}" />
   <link href="{{ URL::to('assets/js/libs/chosen/chosen.css') }}" rel="stylesheet">
   <link href="{{ URL::to('assets/js/libs/chosen/chosen-material-theme.css') }}" rel="stylesheet">
    <style>
        #mapSasCom{
            width: 100%;
            height: 600px;
            border: 1px #aaaaaa dashed;
        }
    </style>

@endsection

@section('section-header')
    Consultas
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-4">
                <form class="form form-validate" role="form" id="formVerMap" novalidate >
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <input type="hidden" name="idprov" id="idprov" >
                    <input type="hidden" name="idrub" id="idrub" >
                    <div class="card">
                        <div class="card-head style-primary">
                            <header>Consulta</header>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="date" class="form-control" id="f1" name="f1" max="{{ date('Y-m-d') }}"  >
                                        <label for="rub1">Fecha inicio</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="date" class="form-control" id="f2" name="f2" max="{{ date('Y-m-d') }}" >
                                        <label for="rub1">Fecha fin</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="nprov" name="nprov" >
                                        <label for="nprov">Proveedor (2 letras para buscar)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="nrub" name="nrub" >
                                        <label for="nrub">Rubro (2 letras para buscar)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-actionbar">
                            <div class="card-actionbar-row">
                                <button type="button" class="btn btn-flat btn-primary ink-reaction" id="btnVerMap">Ver mapa</button>
                            </div>
                        </div>
                    </div><!--end .card -->
                </form>
        </div><!--end .col -->
        <div class="col-lg-8">
           <iframe id="mapSasCom" frameborder="0"></iframe>
        </div>
    </div>



    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="formActMon" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form-validate" role="form" id="actMon" novalidate >
                        {{ csrf_field() }}

                        <input type="hidden" name="id_cod" id="id_cod2" >


                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Actualizar Registro</header>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cicho2" name="cicho" required data-rule-digits="'true" data-inputmask="'mask': '999999[99]'" >
                                            <label for="cicho">Cedula chofer</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nomcho2" name="nomcho" required >
                                            <label for="nomcho">Nombre chofer</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="apecho2" name="apecho" required >
                                            <label for="apecho">Apellido chofer</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="tpove2" name="tpove" required >
                                            <label for="tpove">Tipo vehiculo</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="plave2" name="plave" required data-inputmask="'mask': '*****[***]'">
                                            <label for="plave">Placa vehiculo</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnActMoni">Actualizar</button>
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
    <script src="{{ URL::to('assets/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-validation/dist/localization/messages_es.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/fileuploader/jquery.uploadfile.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/libs/chosen/chosen.jquery.js') }}"></script>
    <script>
        $(function() {
            getProveedor = function(id1, id2, url){
                id_elem = $("#"+id2);
                    $( "#"+id1 ).autocomplete({
                        source: url,
                        minLength: 2,
                        select: function( event, ui ) {
                            id_elem.val(ui.item.id)
                        }
                    });
            }
            getProductoMarca = function(cnd, id1, id2, url, id3){
                if(id3){
                    val_rub = $("#"+id3).val();
                }
                id_elem = $("#"+id2);

                if(cnd=='producto'){
                        $( "#"+id1 ).autocomplete({
                            source: url+'?id_prov='+$('#id_prov').val(),
                            minLength: 2,
                            select: function( event, ui ) {
                                id_elem.val(ui.item.id)
                            }
                        });
                }
                else{
                        $("#"+id1 ).autocomplete({
                            source: function(request, response) {
                                if (val_rub == '') {
                                    swal('Debe elegir un producto!!!', "", "error");
                                    $("#"+id1 ).removeClass( "ui-autocomplete-loading" );
                                }
                                else {
                                    $.ajax({
                                        url: url,
                                        dataType: "json",
                                        data: {term: request.term, rub: val_rub},
                                        success: function (data) {
                                            response(data);
                                        }
                                    })
                                }
                            },
                            close: function( event, ui ) {
                                $("#"+id1 ).removeClass( "ui-autocomplete-loading" );
                            },
                            select: function (event, ui) {
                                            id_elem.val(ui.item.id)
                            },
                            minLength: 2,
                        });
                    }
                }

            var formVerMap = $("#formVerMap");


        });
    </script>
@endsection