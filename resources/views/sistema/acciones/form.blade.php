@foreach($solicitud as $c)
<form class="form form-validate" role="form" id="addAccion" novalidate >
    <input type="hidden" name="_token" value="{{ Session::token() }}">
    <div class="card">
        <div class="card-head card-head-xs style-primary-bright">
            <header>Agregar acciones</header>
        </div>
        <div class="card-body">
            <input type="hidden" name="id_sol" id="id_sol" value="{{ $c->id }}">

            @if($c->objeto == 'PRESENTACIÓN DE PROYECTO')
                @if(!empty($accion->ra_nivel))
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h2>!!!Ya se agrego las acciones permitidas para este objeto!!!</h2>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="ra_nivel" value="1">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" required>
                                <label for="fecha">Fecha</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select id="remitido_a" name="remitido_a" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    <option value="DIRECCION GENERAL DE INVERSION Y PLANES INDUSTRIALES">DIRECCION GENERAL DE INVERSION Y PLANES INDUSTRIALES</option>
                                </select>
                                <label for="remitido_a">Remitido a</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select id="ra_forma" name="ra_forma" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    <option value="EMAIL">EMAIL</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                                <label for="ra_forma">Forma de remisión</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" class="form-control" id="raf_especifique" name="raf_especifique">
                                <label for="raf_especifique">Si es otro, especifique</label>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <input type="text" class="form-control" id="observacion" name="observacion">
                                <label for="observacion">Observación</label>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            @if($c->objeto == 'FINANCIAMIENTO')
                @if(empty($accion->ra_nivel))
                    <input type="hidden" name="ra_nivel" value="1">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}">
                                <label for="fecha">Fecha</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select id="remitido_a" name="remitido_a" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    <option value="DIRECCION GENERAL DE INVERSION Y PLANES INDUSTRIALES">DIRECCION GENERAL DE INVERSION Y PLANES INDUSTRIALES</option>
                                </select>
                                <label for="remitido_a">Remitido a</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select id="ra_forma" name="ra_forma" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    <option value="EMAIL">EMAIL</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                                <label for="ra_forma">Forma de remisión</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" class="form-control" id="raf_especifique" name="raf_especifique">
                                <label for="raf_especifique">Si es otro, especifique</label>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <input type="text" class="form-control" id="observacion" name="observacion">
                                <label for="observacion">Observación</label>
                            </div>
                        </div>
                    </div>
                @elseif($accion->ra_nivel == 1)
                    <input type="hidden" name="ra_nivel" value="2">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}">
                                <label for="fecha">Fecha</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select id="remitido_a" name="remitido_a" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    <option value="BANCO DE VENEZUELA">BANCO DE VENEZUELA</option>
                                    <option value="BANCO DEL TESORO">BANCO DEL TESORO</option>
                                    <option value="BANCO BICENTENARIO">BANCO BICENTENARIO</option>
                                    <option value="BANCOEX">BANCOEX</option>
                                    <option value="BANDES">BANDES</option>
                                    <option value="BANCO AGRICOLA">BANCO AGRICOLA</option>
                                    <option value="BANFANB">BANFANB</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                                <label for="remitido_a">Remitido a</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" class="form-control" id="ra_especifique" name="ra_especifique">
                                <label for="ra_especifique">Si es otro, especifique</label>
                            </div>
                        </div>
                        <!--<div class="col-sm-9">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="rubros">Remitido a (Bancos)</label>
                                        <div id="row">
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline checkbox-styled">
                                                    <input id="b1" name="remitido_a[]" type="checkbox" value="BANCO DE VENEZUELA"><span>BANCO DE VENEZUELA</span>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline checkbox-styled">
                                                    <input id="b2" name="remitido_a[]" type="checkbox" value="BANCO DEL TESORO"><span>BANCO DEL TESORO</span>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline checkbox-styled">
                                                    <input id="b3" name="remitido_a[]" type="checkbox" value="BANCO BICENTENARIO"><span>BANCO BICENTENARIO</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div id="row">

                                            <div class="col-sm-4">
                                                <label class="checkbox-inline checkbox-styled">
                                                    <input id="b4" name="remitido_a[]" type="checkbox" value="BANCOEX"><span>BANCOEX</span>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline checkbox-styled">
                                                    <input id="b5" name="remitido_a[]" type="checkbox" value="BANDES"><span>BANDES</span>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline checkbox-styled">
                                                    <input id="b6" name="remitido_a[]" type="checkbox" value="BANCO AGRICOLA"><span>BANCO AGRICOLA</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="row">
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline checkbox-styled">
                                                    <input id="b7" name="remitido_a[]" type="checkbox" value="BANFANB"><span>BANFANB</span>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline checkbox-styled">
                                                    <input id="b8" name="remitido_a[]" type="checkbox" value="OTRO"><span>OTRO</span>
                                                </label>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="ob" name="remitido_a[]" >
                                                    <label for="ob">Especifique</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end .form-group -->
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select id="ra_forma" name="ra_forma" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    <option value="EMAIL">EMAIL</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                                <label for="ra_forma">Forma de remisión</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="raf_especifique" name="raf_especifique">
                                <label for="raf_especifique">Si es otro, especifique</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="observacion" name="observacion">
                                <label for="observacion">Observación</label>
                            </div>
                        </div>
                    </div>
                @elseif($accion->ra_nivel > 1)
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h2>!!!Ya se agrego las acciones permitidas para este objeto!!!</h2>
                        </div>
                    </div>
                @endif



            @endif

            @if($c->objeto == 'MATERIA PRIMA')

                @if(empty($accion->ra_nivel))
                    <input type="hidden" name="ra_nivel" value="1">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}">
                                <label for="fecha">Fecha</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select id="remitido_a" name="remitido_a" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    <option value="DIRECCION GENERAL DE ENCADENAMIENTOS INDUSTRIALES">DIRECCION GENERAL DE ENCADENAMIENTOS INDUSTRIALES</option>
                                </select>
                                <label for="remitido_a">Remitido a</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select id="ra_forma" name="ra_forma" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    <option value="EMAIL">EMAIL</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                                <label for="ra_forma">Forma de remisión</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" class="form-control" id="raf_especifique" name="raf_especifique">
                                <label for="raf_especifique">Si es otro, especifique</label>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <input type="text" class="form-control" id="observacion" name="observacion">
                                <label for="observacion">Observación</label>
                            </div>
                        </div>
                    </div>
                @elseif($accion->ra_nivel == 1)
                    <input type="hidden" name="ra_nivel" value="2">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}">
                                <label for="fecha">Fecha</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select id="remitido_a" name="remitido_a" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    <option value="ALUMINIO (VENALUM,BAUXILUM, ALUCASA, ALCASA)">ALUMINIO (VENALUM,BAUXILUM, ALUCASA, ALCASA)</option>
                                    <option value="HIERRO-ACERO (SIDOR, FERROMINERA)">HIERRO-ACERO (SIDOR, FERROMINERA)</option>
                                    <option value="COMPLEJO SIDERURGICO NACIONAL (CSN)">COMPLEJO SIDERURGICO NACIONAL (CSN)</option>
                                    <option value="PEQUIVEN">PEQUIVEN</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                                <label for="remitido_a">Remitido a</label>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" class="form-control" id="ra_especifique" name="ra_especifique">
                                <label for="ra_especifique">Si es otro, especifique</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select id="ra_forma" name="ra_forma" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    <option value="EMAIL">EMAIL</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                                <label for="ra_forma">Forma de remisión</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="raf_especifique" name="raf_especifique">
                                <label for="raf_especifique">Si es otro, especifique</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="observacion" name="observacion">
                                <label for="observacion">Observación</label>
                            </div>
                        </div>
                    </div>
                @elseif($accion->ra_nivel > 1)
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h2>!!!Ya se agrego las acciones permitidas para este objeto!!!</h2>
                        </div>
                    </div>
                @endif
            @endif

            @if(strpos($c->objeto, 'PERMISOLOGIA') !== false )

                @if(!empty($accion->ra_nivel))
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h2>!!!Ya se agrego las acciones permitidas para este objeto!!!</h2>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="ra_nivel" value="1">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}">
                                <label for="fecha">Fecha</label>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <select id="remitido_a" name="remitido_a" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    <option value="ENTES ADSCRITOS">ENTES ADSCRITOS</option>
                                    <option value="UNIDADES ADSCRITAS">UNIDADES ADSCRITAS</option>
                                    <option value="ALTAS AUTORIDADES">ALTAS AUTORIDADES</option>
                                    <option value="MINISTRO O VICEMINISTROS">MINISTRO O VICEMINISTROS</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                                <label for="remitido_a">Remitido a</label>
                            </div>
                        </div>



                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" class="form-control" id="ra_especifique" name="ra_especifique" >
                                <label for="ra_especifique">Especifique (si aplica)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select id="ra_forma" name="ra_forma" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    <option value="EMAIL">EMAIL</option>
                                    <option value="OFICIO">OFICIO</option>
                                    <option value="MEMO">MEMO</option>
                                    <option value="LLAMADA TELEFONICA">LLAMADA TELEFONICA</option>
                                    <option value="REMISION DE CASO">REMISION DE CASO</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                                <label for="ra_forma">Forma de remisión</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="raf_especifique" name="raf_especifique">
                                <label for="raf_especifique">Si es otro, especifique</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="observacion" name="observacion">
                                <label for="observacion">Observación</label>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            @if($c->objeto == 'OTROS')
                @if(!empty($accion->ra_nivel))
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h2>!!!Ya se agrego las acciones permitidas para este objeto!!!</h2>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="ra_nivel" value="1">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}">
                                <label for="fecha">Fecha</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="observacion" name="observacion">
                                <label for="observacion">Observación</label>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

        </div>

        <div class="modal-footer">
            @if($c->objeto == 'PRESENTACIÓN DE PROYECTO')
                @if(!empty($accion->ra_nivel))
                    <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                @else
                    <button type="button" class="btn btn-primary" id="btnAdAccion">Guardar</button>
                @endif
            @endif
                @if($c->objeto == 'FINANCIAMIENTO')
                    @if(empty($accion->ra_nivel))
                        <button type="button" class="btn btn-primary" id="btnAdAccion">Guardar</button>
                    @elseif($accion->ra_nivel == 1)
                        <button type="button" class="btn btn-primary" id="btnAdAccion">Guardar</button>
                    @elseif($accion->ra_nivel > 2)
                        <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                    @endif
                @endif
                @if($c->objeto == 'MATERIA PRIMA')
                    @if(empty($accion->ra_nivel))
                        <button type="button" class="btn btn-primary" id="btnAdAccion">Guardar</button>
                    @elseif($accion->ra_nivel == 1)
                        <button type="button" class="btn btn-primary" id="btnAdAccion">Guardar</button>
                    @elseif($accion->ra_nivel > 2)
                        <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                    @endif
                @endif
                @if(strpos($c->objeto, 'PERMISOLOGIA') !== false )
                    @if(!empty($accion->ra_nivel))
                        <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                    @else
                        <button type="button" class="btn btn-primary" id="btnAdAccion">Guardar</button>
                    @endif
                @endif
                @if($c->objeto == 'OTROS')
                    @if(!empty($accion->ra_nivel))
                        <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                    @else
                        <button type="button" class="btn btn-primary" id="btnAdAccion">Guardar</button>
                    @endif
                @endif

        </div>
    </div><!--end .card -->
</form>
@endforeach
<script>
    /*$("#btnAdAccion").click(function () {
        alert('sirve')
    })*/


   /* $("#btnAdAccion").click(function(){

    })*/

    var fAddEmp = $("#addAccion");
    fAddEmp.validate();
    $('#btnAdAccion').click(function(){
        if(fAddEmp.valid()) {
            swal({
                title: "¿Esta seguro que quiere guardar este registro?",
                text: "Esta acción no puede ser desecha",
                type: "warning",
                cancelButtonText: "No",
                showCancelButton: true,
                confirmButtonText: "Si, estoy seguro",
                reverseButtons: true
            }).then(function (text) {
                $.ajax({
                    type: "POST",
                    url:'{!! route('sistema.acciones.add') !!}',
                    data: fAddEmp.serialize(),
                    success: function( data ) {
                        if(data.status == 1){
                            swal(data.msg, "", "success");
                            fAddEmp.clearForm();
                            $("#accAddForm").modal('hide');
                        }
                        else{
                            swal(data.msg, "", "error");
                        }
                    }
                });
            });
        }
    })




</script>