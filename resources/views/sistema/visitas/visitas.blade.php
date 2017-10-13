@extends('layouts.master')
@section('title')
    .:: Visitas ::.
@endsection
@section('styles')
  <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/DataTables/jquery.dataTables.css') }}" >
   <link href="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/css/responsive.dataTables.css') }}" rel="stylesheet">
   <link href="{{ URL::to('assets/js/libs/jquery-datatable/extensions/responsive/css/responsive.bootstrap.css') }}" rel="stylesheet">
   <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/fileuploader/uploadfile.css') }}" >
   <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/summernote/summernote.css?1425218701') }}" />
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
    Visitas
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <button type="button" class="btn ink-reaction btn-floating-action btn-sm btn-primary pull-right" id="btnAddVis" title="Agregar registro">
                <i class="fa fa-plus-square"></i>
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dt_emp" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="sort-alpha">Fecha</th>
                        <th class="sort-alpha" width="25%">Empresa</th>
                        <th class="sort-alpha">RIF</th>
                        <th class="sort-alpha">Tiempo de operatividad</th>
                        <th class="sort-alpha">CIIU/CAEV</th>
                        <th class="sort-alpha">Estado</th>
                        <th class="sort-alfha">Municipio</th>
                        <th class="sort-alpha">Parroquia</th>
                        <th class="sort-alpha">Dirección</th>

                        <th class="sort-alpha">Tipo empresa</th>
                        <th class="sort-alpha">Nº Trabajadores</th>
                        <th class="sort-alpha">Si son más de 200, especifique</th>

                        <th class="sort-alpha">Servicios</th>
                        <th class="sort-alpha">Objeto empresa</th>

                        <th class="sort-alpha">Líneas producción</th>
                        <th class="sort-alpha">N críticos produccion</th>
                        <th class="sort-alpha">N críticos materia prima</th>
                        <th class="sort-alpha">Principales clientes (producción)</th>
                        <th class="sort-alpha">Principales estado (producción)</th>
                        <th class="sort-alpha">Proceso productivo</th>
                        <th class="sort-alpha">Observaciones generales</th>
                        <th class="sort-alpha" style="width: 20% !important;">&nbsp;</th>
                    </tr>
                    </thead>
                </table>
            </div><!--end .table-responsive -->
        </div><!--end .col -->
    </div><!--end .row -->

    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="formAddVis" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form-validate" role="form" id="addVis" novalidate >
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <input type="hidden" name="emp_rif" id="emp_rif">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Agregar Visita</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="empresa" name="empresa" onfocus="getEmpresa('empresa', 'emp_rif', '{!! route('sistema.getEmpresa') !!}')" required>
                                            <label for="empresa">Empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                                            <label for="fecha">Fecha</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="operatividad" name="operatividad" required>
                                            <label for="operatividad">Tiempo de operatividad de la empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="ciiu" name="ciiu" required>
                                            <label for="ciiu">CIIU/CAEV</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="tipo_emp" name="tipo_emp" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="PUBLICA">PUBLICA</option>
                                                <option value="PRIVADA">PRIVADA</option>
                                                <option value="MIXTA">MIXTA</option>
                                                <option value="COOPERATIVA">COOPERATIVA</option>
                                                <option value="NUEVO EMPRENDEDOR">NUEVO EMPRENDEDOR</option>
                                            </select>
                                            <label for="tipo_emp">Tipo de empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="trabajadores" name="trabajadores" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="ENTRE 1 Y 5">ENTRE 1 Y 5</option>
                                                <option value="ENTRE 6 Y 15">ENTRE 6 Y 15</option>
                                                <option value="ENTRE 16 Y 30">ENTRE 16 Y 30</option>
                                                <option value="ENTRE 30 Y 50">ENTRE 30 Y 50</option>
                                                <option value="ENTRE 51 Y 100">ENTRE 51 Y 100</option>
                                                <option value="ENTRE 101 Y 199">ENTRE 101 Y 199</option>
                                                <option value="MAS 200">MAS 200</option>
                                            </select>
                                            <label for="trabajadores">Número de trabajadores</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="tnum" name="tnum" data-type='number' required>
                                            <label for="tnum">Si es más de 200 especifique</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="servicios" id="servicios" class="form-control" rows="2" placeholder="Separados por coma (,)" required ></textarea>
                                            <label for="servicios">Servicios</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <textarea name="objeto" id="objeto" class="form-control" rows="2" placeholder="" required></textarea>
                                            <label for="objeto">Objeto de la empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="l_prod" name="l_prod" data-type='number' required >
                                            <label for="l_prod">Líneas de producción</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="nc_prod" id="nc_prod" class="form-control" rows="2" placeholder="Separados por coma (,)" required ></textarea>
                                            <label for="nc_prod">Nudos críticos para la producción</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="nc_mprima" id="nc_mprima" class="form-control" rows="2" placeholder="Separados por coma (,)" required ></textarea>
                                            <label for="nc_mprima">Nudos críticos para la adquisición de materia prima</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <textarea name="pclientes" id="pclientes" class="form-control" rows="2" placeholder="Separados por coma (,)" required ></textarea>
                                            <label for="pclientes">Destino de colocación de la producción principales clientes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <textarea name="pedo" id="pedo" class="form-control" rows="2" placeholder="Separados por coma (,)" required ></textarea>
                                            <label for="pedo">Destino de colocación de la producción por estado</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="pproductivo" id="pproductivo" class="form-control" rows="2" placeholder="pasos separados por coma (,)" required ></textarea>
                                            <label for="pproductivo">Describa el Proceso productivo (paso a paso)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="observacion" id="observacion" class="form-control" rows="2" placeholder="pasos separados por coma (,)" required ></textarea>
                                            <label for="observacion">Observaciones generales</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnFormAddVis">Guardar</button>
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
    <div class="modal fade" id="formUpdVis" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form-validate" role="form" id="updVis" novalidate >
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <input type="hidden" name="id" id="vis_id">
                        <input type="hidden" name="emp_rif" id="emp_rif2">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Actualizar Visita</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="empresa2" name="empresa" onfocus="getEmpresa('empresa2', 'emp_rif2', '{!! route('sistema.getEmpresa') !!}')" required>
                                            <label for="empresa2">Empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="fecha2" name="fecha" required>
                                            <label for="fecha2">Fecha</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="operatividad2" name="operatividad" required>
                                            <label for="operatividad2">Tiempo de operatividad de la empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="ciiu2" name="ciiu" required>
                                            <label for="ciiu2">CIIU/CAEV</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="tipo_emp2" name="tipo_emp" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="PUBLICA">PUBLICA</option>
                                                <option value="PRIVADA">PRIVADA</option>
                                                <option value="MIXTA">MIXTA</option>
                                                <option value="COOPERATIVA">COOPERATIVA</option>
                                                <option value="NUEVO EMPRENDEDOR">NUEVO EMPRENDEDOR</option>
                                            </select>
                                            <label for="tipo_emp2">Tipo de empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="trabajadores2" name="trabajadores" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="ENTRE 1 Y 5">ENTRE 1 Y 5</option>
                                                <option value="ENTRE 6 Y 15">ENTRE 6 Y 15</option>
                                                <option value="ENTRE 16 Y 30">ENTRE 16 Y 30</option>
                                                <option value="ENTRE 30 Y 50">ENTRE 30 Y 50</option>
                                                <option value="ENTRE 51 Y 100">ENTRE 51 Y 100</option>
                                                <option value="ENTRE 101 Y 199">ENTRE 101 Y 199</option>
                                                <option value="MAS 200">MAS 200</option>
                                            </select>
                                            <label for="trabajadores2">Número de trabajadores</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="tnum2" name="tnum" data-type='number' >
                                            <label for="tnum2">Si es más de 200 especifique</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="servicios" id="servicios2" class="form-control" rows="2" placeholder="Separados por coma (,)" required ></textarea>
                                            <label for="servicios2">Servicios</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <textarea name="objeto" id="objeto2" class="form-control" rows="2" placeholder="" required></textarea>
                                            <label for="objeto2">Objeto de la empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="l_prod2" name="l_prod" data-type='number' required >
                                            <label for="l_prod2">Líneas de producción</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="nc_prod" id="nc_prod2" class="form-control" rows="2" placeholder="Separados por coma (,)" required ></textarea>
                                            <label for="nc_prod2">Nudos críticos para la producción</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="nc_mprima" id="nc_mprima2" class="form-control" rows="2" placeholder="Separados por coma (,)" required ></textarea>
                                            <label for="nc_mprima2">Nudos críticos para la adquisición de materia prima</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <textarea name="pclientes" id="pclientes2" class="form-control" rows="2" placeholder="Separados por coma (,)" required ></textarea>
                                            <label for="pclientes2">Destino de colocación de la producción principales clientes</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <textarea name="pedo" id="pedo2" class="form-control" rows="2" placeholder="Separados por coma (,)" required ></textarea>
                                            <label for="pedo2">Destino de colocación de la producción por estado</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="pproductivo" id="pproductivo2" class="form-control" rows="2" placeholder="pasos separados por coma (,)" required ></textarea>
                                            <label for="pproductivo2">Describa el Proceso productivo (paso a paso)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="observacion" id="observacion2" class="form-control" rows="2" placeholder="pasos separados por coma (,)" required ></textarea>
                                            <label for="observacion2">Observaciones generales</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnFormUpdVis">Actualizar</button>
                                <!--<input type="submit" class="btn btn-primary" value="Guardar">-->
                            </div>
                        </div><!--end .card -->
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END FORM MODAL MARKUP -->

    <!-- produccion -->
    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="formAddVProd" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form-validate" role="form" id="addVPro" novalidate >
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <input type="hidden" name="vis_id" id="visp_id">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Agregar Producción</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="producto" name="producto"  required>
                                            <label for="producto">Producto</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cod_aran" name="cod_aran" required>
                                            <label for="cod_aran">Código arancelario</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select id="medida" name="medida" class="form-control" required>
                                                <option value="UND">UNIDAD (UND)</option>
                                                <option value="GR">GRAMOS (GR)</option>
                                                <option value="KG">KILOGRAMOS (KG)</option>
                                                <option value="TN">TONELADA (TN)</option>
                                                <option value="TNM">TONELADA METRICA (TNM)</option>
                                                <option value="ML">MILILITROS (ML)</option>
                                                <option value="LT">LITROS (LT)</option>
                                                <option value="CM3">CENTIMETRO CUBICO (CM3)</option>
                                                <option value="M3">METRO CUBICO (M3)</option>
                                                <option value="M2">METROS CUADRADOS (M2)</option>
												<option value="CM">CENTIMETRO (CM)</option>
												<option value="MT">METRO (MT)</option>
                                                <option value="PAR">PAR</option>
                                            </select>
                                            <label for="medida">Unidad de medida</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cinstalada" name="cinstalada" data-type="number" required>
                                            <label for="cinstalada">Capacidad instalada (mes)</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="coperativa" name="coperativa" data-type="number" required>
                                            <label for="coperativa">Capacidad utilizada (mes)</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="prodaant" name="prodaant" data-type="number" required>
                                            <label for="prodaant">Producción año anterior</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="prodact" name="prodact" data-type="number" required>
                                            <label for="prodact">Producción actual (mes)</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="prodmeta" name="prodmeta" data-type="number" required>
                                            <label for="prodmeta">Producción meta (año en curso)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnFAddVProd">Guardar</button>
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
    <div class="modal fade" id="modalTableProd" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-head style-primary">
                            <div class="tools">
                                <div class="btn-group">
                                    <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                </div>
                            </div>
                            <header>Producción</header>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dt_pro" class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th class="sort-alpha">Producto</th>
                                        <th class="sort-alpha">Cód arancelario</th>
                                        <th class="sort-alpha">Medida</th>
                                        <th class="sort-alpha">Cap Instalada (mes)</th>
                                        <th class="sort-alfha">Cap Utilizada (mes)</th>
                                        <th class="sort-alpha">Prod anual (Año ant)</th>
                                        <th class="sort-alpha">Prod Actual (mes) </th>
                                        <th class="sort-alpha">Prod meta (Año act)</th>
                                        <th class="sort-alpha" style="width: 5% !important;">&nbsp;</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div><!--end .table-responsive -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                        </div>
                    </div><!--end .card -->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END FORM MODAL MARKUP -->

    <!-- materia prima -->
    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="formAddVMPrima" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form-validate" role="form" id="addVMPrima" novalidate >
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <input type="hidden" name="vis_id" id="vismp_id">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Agregar Materia Prima</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="producto" name="producto"  required>
                                            <label for="producto">Producto</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="proveedor" name="proveedor" required>
                                            <label for="proveedor">Proveedor</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cod_aranmp" name="cod_aran" required>
                                            <label for="cod_aranmp">Código arancelario</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="medida" name="medida" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="UND">UNIDAD (UND)</option>
                                                <option value="GR">GRAMOS (GR)</option>
                                                <option value="KG">KILOGRAMOS (KG)</option>
                                                <option value="TN">TONELADA (TN)</option>
                                                <option value="TNM">TONELADA METRICA (TNM)</option>
                                                <option value="ML">MILILITROS (ML)</option>
                                                <option value="LT">LITROS (LT)</option>
                                                <option value="CM3">CENTIMETRO CUBICO (CM3)</option>
                                                <option value="M3">METRO CUBICO (M3)</option>
                                                <option value="M2">METRO CUADRADO (M2)</option>
												<option value="CM">CENTIMETRO (CM)</option>
												<option value="MT">METRO (MT)</option>
                                                <option value="PAR">PAR</option>
                                            </select>
                                            <label for="medida">Unidad de medida</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="creq" name="creq" data-type="number" required>
                                            <label for="creq">Cantidad requerida (mes)</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cdis" name="cdis" data-type="number" required>
                                            <label for="cdis">Cantidad disponible</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnFAddVMPrima">Guardar</button>
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
    <div class="modal fade" id="modalTableMPri" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-head style-primary">
                            <div class="tools">
                                <div class="btn-group">
                                    <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                </div>
                            </div>
                            <header>Materia Prima</header>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dt_mpri" class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th class="sort-alpha">Producto</th>
                                        <th class="sort-alpha">Proveedor</th>
                                        <th class="sort-alpha">Cód arancelario</th>
                                        <th class="sort-alpha">Medida</th>
                                        <th class="sort-alfha">Cant req (mes)</th>
                                        <th class="sort-alpha">Cant Disp</th>
                                        <th class="sort-alpha" style="width: 5% !important;">&nbsp;</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div><!--end .table-responsive -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                        </div>
                    </div><!--end .card -->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END FORM MODAL MARKUP -->

    <!-- comercializacion -->
    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="formAddVCom" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form-validate" role="form" id="addVCom" novalidate >
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <input type="hidden" name="vis_id" id="visc_id">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Agregar Comercialización</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="producto" name="producto"  required>
                                            <label for="producto">Producto</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cod_aranc" name="cod_aran" required>
                                            <label for="cod_aranc">Código arancelario</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="minterno" name="minterno" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="minterno">Mercado Interno</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="exportacion" name="exportacion" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="exportacion">Exportación</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="preciobs" name="preciobs" data-type="number" required>
                                            <label for="preciobs">Precio Bs.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="ventanac" name="ventanac" data-type="number" required>
                                            <label for="ventanac">Venta nac. año anterior</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="ventanacest" name="ventanacest" data-type="number" required>
                                            <label for="ventanacest">Venta est. año actual</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="exportacionusd" name="exportacionusd" data-type="number" required>
                                            <label for="exportacionusd">Exportacion USD año anterior</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="exportacionestusd" name="exportacionestusd" data-type="number" required>
                                            <label for="exportacionestusd">Exportacion USD est. año actual</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnFAddVCom">Guardar</button>
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
    <div class="modal fade" id="modalTableCom" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-head style-primary">
                            <div class="tools">
                                <div class="btn-group">
                                    <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                </div>
                            </div>
                            <header>Comercialización</header>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dt_com" class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th class="sort-alpha">Producto</th>
                                        <th class="sort-alpha">Cód aran</th>
                                        <th class="sort-alpha">Mercado int</th>
                                        <th class="sort-alpha">Exportación</th>
                                        <th class="sort-alfha">Precio Bs.</th>
                                        <th class="sort-alpha">Venta Nac (año ant)</th>
                                        <th class="sort-alpha">Venta Nac est (año act)</th>
                                        <th class="sort-alpha">Exp año ant (USD)</th>
                                        <th class="sort-alpha"> Exp est año act (USD)</th>
                                        <th class="sort-alpha" style="width: 5% !important;">&nbsp;</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div><!--end .table-responsive -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                        </div>
                    </div><!--end .card -->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END FORM MODAL MARKUP -->

    <!-- inversion permisos -->
    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="formAddVInv" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form-validate" role="form" id="addVInv" novalidate >
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <input type="hidden" name="vis_id" id="visi_id">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Agregar Inversión/Permisos</header>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select id="financiamiento" name="financiamiento" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="financiamiento">Requiere Financiamiento</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="montobs" name="montobs" data-type="number" required>
                                            <label for="montobs">Monto en BS</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="montousd" name="montousd" data-type="number" required>
                                            <label for="montousd">Monto en USD</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="uso" id="uso" class="form-control" rows="2" placeholder="Separados por coma (,)" required ></textarea>
                                            <label for="uso">Uso del Financiamiento</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select id="pdicom" name="pdicom" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="pdicom">Postura de compra de divisas en el Sistema DICOM</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select id="exportacion" name="sdicom" class="form-control" required>
                                                <option value="">&nbsp;</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="sdicom">Adjudicado en las subastas</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nsubastas" name="nsubastas" data-type="number" required>
                                            <label for="nsubastas">Números de Subastas</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="asignacion" name="asignacion" data-type="number" required>
                                            <label for="asignacion">Monto asignado USD</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="rfinaciamiento" id="rfinaciamiento" class="form-control" rows="2" placeholder="Separados por coma (,)" required ></textarea>
                                            <label for="rfinaciamiento">Recibido financiamiento (Por ente o banco)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cartera" name="cartera" required>
                                            <label for="cartera">Cartera dirigida</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="montofin" name="montofin" data-type="number" required>
                                            <label for="montofin">Monto financiado</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="permisos" id="permisos" class="form-control" rows="2" placeholder="Separados por coma (,)" required ></textarea>
                                            <label for="permisos">Permisos, licencias, certificados y trámites</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnFAddVInv">Guardar</button>
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
    <div class="modal fade" id="modalDivInv" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                        <div class="card">
                            <div class="card-head style-primary">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                    </div>
                                </div>
                                <header>Inversión/Permisos</header>
                            </div>
                            <div class="card-body">
                                <div id="cuerpoInvPer"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                            </div>
                        </div><!--end .card -->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END FORM MODAL MARKUP -->


<!-- ficha-->
    <!-- BEGIN FORM MODAL MARKUP -->
    <div class="modal fade" id="modalIfrFicha" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-head style-primary">
                            <div class="tools">
                                <div class="btn-group">
                                    <a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
                                </div>
                            </div>
                            <header>Ficha resumen</header>
                        </div>
                        <div class="card-body">
                            <iframe src="" frameborder=0" style="width: 100%; height: 80vh;" id="iframeFicha"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="btnPrintFicha">Imprimir Ficha</button>
                            <button type="button" class="btn btn-danger" id="btnDesFicha">Descargar Ficha</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                        </div>
                    </div><!--end .card -->
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
    <script src="{{ URL::to('assets/js/libs/summernote/summernote.min.js') }}"></script>
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

            $('#btnPrintFicha').click(function(){
                $('#iframeFicha').get(0).contentWindow.focus();
                //Ejecutamos la impresion sobre ese control
                $("#iframeFicha").get(0).contentWindow.print();
            })



            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ Session::token() }}'
                }
            });

            $("input[data-type='number']").inputmask("decimal", {
                radixPoint: ",",
                autoGroup: true,
                groupSeparator: ".",
                groupSize: 3,
                autoUnmask: true
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
                    {extend:'pdfHtml5',text:'<i class="fa fa-file-pdf-o"></i>',titleAttr: 'PDF', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs', orientation: 'landscape', pageSize: 'LEGAL'}
                ],
                language: {
                    url: '{{ URL::to('assets/js/libs/DataTables/spanish.json') }}'
                },
                ajax: {
                    url: '{!! route('sistema.visitas.data') !!}',
                    method: 'POST'
                },
                columns:
                [
                { data: 'fecha', name: 'fecha' },
                { data: 'empresa', name: 'empresas.empresa' },
                { data: 'rif', name: 'empresas.rif', orderable: false, searchable: false, visible: false    },
                { data: 'operatividad', name: 'vis_visitas.operatividad', orderable: false, searchable: false, visible: false    },
                { data: 'ciiu', name: 'vis_visitas.ciiu', orderable: false, searchable: false, visible: false    },
                { data: 'edo', name: 'estados.nombre'  },
                { data: 'mcpio', name: 'municipios.nombre', orderable: false, searchable: false, visible: false  },
                { data: 'pquia', name: 'parroquias.nombre', orderable: false, searchable: false, visible: false  },
                { data: 'direccion', name: 'empresas.direccion', orderable: false, searchable: false, visible: false  },


                { data: 'tipo_emp', name: 'vis_visitas.tipo_emp'  },
                { data: 'trabajadores', name: 'vis_visitas.trabajadores', orderable: false, searchable: false, visible: false  },
                { data: 'tnum', name: 'vis_visitas.tnum', orderable: false, searchable: false, visible: false  },
                { data: 'servicios', name: 'vis_visitas.servicios', orderable: false, searchable: false, visible: false  },
                { data: 'objeto', name: 'vis_visitas.objeto', orderable: false, searchable: false, visible: false  },

                { data: 'l_prod', name: 'vis_visitas.l_prod', orderable: false, searchable: false, visible: false  },
                { data: 'nc_prod', name: 'vis_visitas.nc_prod', orderable: false, searchable: false, visible: false  },
                { data: 'nc_mprima', name: 'vis_visitas.nc_mprima', orderable: false, searchable: false, visible: false   },
                { data: 'pclientes', name: 'vis_visitas.pclientes', orderable: false, searchable: false, visible: false  },

                { data: 'pedo', name: 'vis_visitas.pedo', orderable: false, searchable: false, visible: false  },
                { data: 'pproductivo', name: 'vis_visitas.pproductivo', orderable: false, searchable: false, visible: false  },
                { data: 'observacion', name: 'vis_visitas.observacion', orderable: false, searchable: false, visible: false  },

                { data: 'accion', name: 'accion', orderable: false, searchable: false }
                ]
            });

            $("#btnAddVis").click(function(){
                $("#addVis").clearForm();
                $("#formAddVis").modal('show');
            })

            var fAddVis = $("#addVis");
            fAddVis.validate();
            $('#btnFormAddVis').click(function(){
                if(fAddVis.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.visitas.add') !!}',
                        data: fAddVis.serialize(),
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                table.ajax.reload( null, false );
                                fAddVis.clearForm();
                                $("#formAddVis").modal('hide');
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                }
            })

            findUpdateVis  = function(id){
                $.ajax({
                    type: "POST",
                    url:'{!! route('sistema.visitas.find') !!}',
                    data: {"_token": "{{ csrf_token() }}", "id": id},
                    success: function( data ) {
                        $.each(data, function(i, item) {

                            $("#vis_id").val(item.id);
                            $("#emp_rif2").val(item.rif);
                            $("#empresa2").val(item.empresa);
                            $("#fecha2").val(item.fecha);
                            $("#operatividad2").val(item.operatividad);
                            $("#ciiu2").val(item.ciiu);

                            $("#tipo_emp2").append($('<option>').text(item.tipo_emp).attr({value: item.tipo_emp,selected: "selected"}));
                            $("#trabajadores2").append($('<option>').text(item.trabajadores).attr({value: item.trabajadores,selected: "selected"}));
                            $("#tnum2").val(item.tnum);

                            $("#servicios2").val(item.servicios);
                            $("#objeto2").val(item.objeto);

                            $("#l_prod2").val(item.l_prod);
                            $("#nc_prod2").val(item.nc_prod);
                            $("#nc_mprima2").val(item.nc_mprima);
                            $("#pclientes2").val(item.pclientes);

                            $("#pedo2").val(item.pedo);
                            $("#pproductivo2").val(item.pproductivo);
                            $("#observacion2").val(item.observacion);
                        })
                        $("#formUpdVis").modal('show');
                    }
                });

            }

            var fActVis = $("#updVis");

            $('#formUpdVis').on('hidden.bs.modal', function (e) {
                $("#tipo_emp2 option:last, #trabajadores2 option:last").remove();
                fActVis.clearForm();
            })

            fActVis.validate();
            $('#btnFormUpdVis').click(function(){
                if(fActVis.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.visitas.upd') !!}',
                        data: fActVis.serialize(),
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                table.ajax.reload( null, false );
                                fActVis.clearForm();
                                $("#formUpdVis").modal('hide');
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                }
            })

            deleteVis = function(id){
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
                        url:'{!! route('sistema.visitas.del') !!}',
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

            verFichaVisitas  = function(id){
                $('#iframeFicha').attr('src', '{{ route('sistema.visitas.view') }}?id='+id);
                $("#modalIfrFicha").modal('show');
                $('#btnDesFicha').click(function () {
                    location.href = '{{ route('sistema.visitas.ficha') }}?id='+id;
                })
            }
            $("#iframeFicha").on("load", function () {
                $('#iframeFicha').fadeIn(2000);
            })

            $('#modalIfrFicha').on('hidden.bs.modal', function (e) {
                $('#iframeFicha').attr('src', '#');
                fActVis.clearForm();
            })


            /*produccion*/
            cargarProduccion = function (id) {
                swal({
                    title: '¿Qué desea hacer?',
                    type: "question",
                    html: "<br>" +
                    '<button type="button" role="button" tabindex="0" class="btn btn-primary" id="btnAddProd">' + 'Agregar producción' + '</button>&nbsp;&nbsp;' +
                    '<button type="button" role="button" tabindex="0" class="btn btn-success" id="btnViewProd">' + 'Ver registros' + '</button>',
                    showCancelButton: false,
                    showConfirmButton: false
                });
                $('#btnAddProd').click(function(){
                    swal.clickConfirm();
                    $("#addVPro").clearForm();
                    $('#visp_id').val(id);
                    $('#formAddVProd').modal('show');
                })

                $('#btnViewProd').click(function(){
                    swal.clickConfirm();
                    td_vpro = tableProduccion(id)
                    $('#modalTableProd').modal('show');
                })
            }
            var fAddVPro = $("#addVPro");
            fAddVPro.validate();
            $('#btnFAddVProd').click(function(){
                if(fAddVPro.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.visitas.produccion.add') !!}',
                        data: fAddVPro.serialize(),
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                //table.ajax.reload( null, false );
                                fAddVPro.clearForm();
                                $("#formAddVProd").modal('hide');
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                }
            })
            deleteVPro = function(id){
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
                        url:'{!! route('sistema.visitas.produccion.del') !!}',
                        data: {"_token": "{{ csrf_token() }}", "id": id},
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                td_vpro.ajax.reload( null, false );
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                });

            }

            /*materia prima*/
            cargarMPrima = function (id) {
                swal({
                    title: '¿Qué desea hacer?',
                    type: "question",
                    html: "<br>" +
                    '<button type="button" role="button" tabindex="0" class="btn btn-primary" id="btnAddMPrima">' + 'Agregar materia prima' + '</button>&nbsp;&nbsp;' +
                    '<button type="button" role="button" tabindex="0" class="btn btn-success" id="btnViewMPrima">' + 'Ver registros' + '</button>',
                    showCancelButton: false,
                    showConfirmButton: false
                });
                $('#btnAddMPrima').click(function(){
                    swal.clickConfirm();
                    $("#addVMPrima").clearForm();
                    $('#vismp_id').val(id);
                    $('#formAddVMPrima').modal('show');
                })

                $('#btnViewMPrima').click(function(){
                    swal.clickConfirm();
                    td_vmpri = tableMPrima(id)
                    $('#modalTableMPri').modal('show');
                })
            }
            var fAddVMPrima = $("#addVMPrima");
            fAddVMPrima.validate();
            $('#btnFAddVMPrima').click(function(){
                if(fAddVMPrima.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.visitas.mprima.add') !!}',
                        data: fAddVMPrima.serialize(),
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                //table.ajax.reload( null, false );
                                fAddVMPrima.clearForm();
                                $("#formAddVMPrima").modal('hide');
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                }
            })
            deleteVMPri = function(id){
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
                        url:'{!! route('sistema.visitas.mprima.del') !!}',
                        data: {"_token": "{{ csrf_token() }}", "id": id},
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                td_vmpri.ajax.reload( null, false );
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                });

            }

            /*comercializacion*/
            cargarComercializacion = function (id) {
                swal({
                    title: '¿Qué desea hacer?',
                    type: "question",
                    html: "<br>" +
                    '<button type="button" role="button" tabindex="0" class="btn btn-primary" id="btnAddCom">' + 'Agregar comercialización' + '</button>&nbsp;&nbsp;' +
                    '<button type="button" role="button" tabindex="0" class="btn btn-success" id="btnViewCom">' + 'Ver registros' + '</button>',
                    showCancelButton: false,
                    showConfirmButton: false
                });
                $('#btnAddCom').click(function(){
                    swal.clickConfirm();
                    $('#addVCom').clearForm();
                    $('#visc_id').val(id);
                    $('#formAddVCom').modal('show');
                })

                $('#btnViewCom').click(function(){
                    swal.clickConfirm();
                    td_vcom = tableComercializacion(id);
                    $('#modalTableCom').modal('show');
                })
            }
            var fAddVCom = $("#addVCom");
            fAddVCom.validate();
            $('#btnFAddVCom').click(function(){
                if(fAddVCom.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.visitas.comercial.add') !!}',
                        data: fAddVCom.serialize(),
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                //table.ajax.reload( null, false );
                                fAddVCom.clearForm();
                                $("#formAddVCom").modal('hide');
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                }
            })
            deleteCom = function(id){
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
                        url:'{!! route('sistema.visitas.comercial.del') !!}',
                        data: {"_token": "{{ csrf_token() }}", "id": id},
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                td_vcom.ajax.reload( null, false );
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                });

            }

            /*inversion*/
            cargarInvPer = function (id) {
                swal({
                    title: '¿Qué desea hacer?',
                    type: "question",
                    html: "<br>" +
                    '<button type="button" role="button" tabindex="0" class="btn btn-primary" id="btnAddInv">' + 'Agregar Inversión/Permisos' + '</button>&nbsp;&nbsp;' +
                    '<button type="button" role="button" tabindex="0" class="btn btn-success" id="btnViewInv">' + 'Ver registros' + '</button>',
                    showCancelButton: false,
                    showConfirmButton: false
                });
                $('#btnAddInv').click(function(){
                    swal.clickConfirm();
                    $("#addVInv").clearForm();
                    $('#visi_id').val(id);
                    $('#formAddVInv').modal('show');
                })

                $('#btnViewInv').click(function(){
                    swal.clickConfirm();
                    dataInvPer(id, 'cuerpoInvPer')
                    $('#modalDivInv').modal('show');

                })
            }
            var fAddVInv = $("#addVInv");
            fAddVInv.validate();
            $('#btnFAddVInv').click(function(){
                if(fAddVInv.valid()){
                    $.ajax({
                        type: "POST",
                        url:'{!! route('sistema.visitas.inversion.add') !!}',
                        data: fAddVInv.serialize(),
                        success: function( data ) {
                            if(data.status == 1){
                                swal(data.msg, "", "success");
                                //table.ajax.reload( null, false );
                                fAddVCom.clearForm();
                                $("#formAddVInv").modal('hide');
                            }
                            else{
                                swal(data.msg, "", "error");
                            }
                        }
                    });
                }
            })

        });

        function tableProduccion(id){
            ptable = $('#dt_pro').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                destroy: true,
                lengthMenu: [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "All"]],
                "order": [[ 0, "desc" ]],
                dom: 'Blfrtip',
                buttons: [
                    {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o"></i>',titleAttr: 'Excel', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs'},
                ],
                language: {
                    url: '{{ URL::to('assets/js/libs/DataTables/spanish.json') }}'
                },
                ajax: {
                    url: '{!! route('sistema.visitas.produccion.data') !!}?id='+id,
                    method: 'POST'
                },
                columns:
                    [
                        { data: 'producto', name: 'vis_produccion.producto' },
                        { data: 'cod_aran', name: 'vis_produccion.cod_aran' },
                        { data: 'medida', name: 'vis_produccion.medida'   },
                        { data: 'cinstalada', name: 'vis_produccion.cinstalada'  },
                        { data: 'coperativa', name: 'vis_produccion.coperativa'  },
                        { data: 'prodaant', name: 'vis_produccion.prodaant' },
                        { data: 'prodact', name: 'vis_produccion.prodact' },
                        { data: 'prodmeta', name: 'vis_produccion.prodmeta'  },
                        { data: 'accion', name: 'accion', orderable: false, searchable: false }
                    ]
            });
            return ptable;
        }

        function tableMPrima(id){
            ptable = $('#dt_mpri').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                destroy: true,
                lengthMenu: [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "All"]],
                "order": [[ 0, "desc" ]],
                dom: 'Blfrtip',
                buttons: [
                    {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o"></i>',titleAttr: 'Excel', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs'},
                ],
                language: {
                    url: '{{ URL::to('assets/js/libs/DataTables/spanish.json') }}'
                },
                ajax: {
                    url: '{!! route('sistema.visitas.mprima.data') !!}?id='+id,
                    method: 'POST'
                },
                columns:
                    [
                        { data: 'producto', name: 'vis_mprima.producto' },
                        { data: 'proveedor', name: 'vis_mprima.medida'   },
                        { data: 'cod_aran', name: 'vis_mprima.cod_aran' },
                        { data: 'medida', name: 'vis_mprima.medida'  },
                        { data: 'creq', name: 'vis_mprima.creq'  },
                        { data: 'cdis', name: 'vis_mprima.cdis' },
                        { data: 'accion', name: 'accion', orderable: false, searchable: false }
                    ]
            });
            return ptable;
        }

        function tableComercializacion(id){
            ptable = $('#dt_com').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                destroy: true,
                lengthMenu: [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "All"]],
                "order": [[ 0, "desc" ]],
                dom: 'Blfrtip',
                buttons: [
                    {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o"></i>',titleAttr: 'Excel', className: 'btn ink-reaction btn-floating-action btn-primary btn-xs'},
                ],
                language: {
                    url: '{{ URL::to('assets/js/libs/DataTables/spanish.json') }}'
                },
                ajax: {
                    url: '{!! route('sistema.visitas.comercial.data') !!}?id='+id,
                    method: 'POST'
                },
                columns:
                    [
                        { data: 'producto', name: 'vis_comercializacion.producto' },
                        { data: 'cod_aran', name: 'vis_comercializacion.cod_aran' },
                        { data: 'minterno', name: 'vis_comercializacion.minterno'   },
                        { data: 'exportacion', name: 'vis_comercializacion.exportacion'  },
                        { data: 'preciobs', name: 'vis_comercializacion.preciobs'  },
                        { data: 'ventanac', name: 'vis_comercializacion.ventanac' },
                        { data: 'ventanacest', name: 'vis_comercializacion.ventanacest'  },
                        { data: 'exportacionusd', name: 'vis_comercializacion.exportacionusd'  },
                        { data: 'exportacionestusd', name: 'vis_comercializacion.exportacionestusd' },
                        { data: 'accion', name: 'accion', orderable: false, searchable: false }
                    ]
            });
            return ptable;
        }

        function dataInvPer(id, div){
            $.ajax({
                type: "POST",
                url:'{!! route('sistema.visitas.inversion.data') !!}',
                data: {"_token": "{{ csrf_token() }}", "id": id},
                success: function( data ) {
                    $('#'+div).empty().html(data);
                }
            });
        }



    </script>
@endsection