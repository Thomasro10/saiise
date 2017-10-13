@foreach($solicitud as $c)
    @if($status == 'CULMINADO')
        <div class="card">
            <div class="card-head card-head-xs style-primary-bright">
                <header>Agregar Seguimiento</header>
            </div>
            <div class="card-body">
                <h3>¡¡¡Ya el proceso para esta solicitud esta culminado!!!</h3>
            </div>
        </div>
    @else
        <form class="form form-validate" role="form" id="addAccion" novalidate >
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <div class="card">
                <div class="card-head card-head-xs style-primary-bright">
                    <header>Agregar Seguimiento</header>
                </div>
                <div class="card-body">
                    <input type="hidden" name="id_sol" id="id_sol" value="{{ $c->id }}">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}">
                                <label for="fecha">Fecha</label>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <select id="status" name="status" class="form-control" required>
                                    <option value="">&nbsp;</option>
                                    @if($status == 'EN PROCESO')
                                        <option value="EN REVISION">EN REVISION</option>
                                        <option value="APROBADO">APROBADO</option>
                                        <option value="RECHAZADO">RECHAZADO</option>
                                        <option value="CULMINADO">CULMINADO</option>
                                        <optgroup label="Solo en caso de requerimiento financiero o materia prima">
                                            <option value="LIQUIDADO">LIQUIDADO</option>
                                            <option value="ENTREGADO">ENTREGADO</option>
                                        </optgroup>
                                    @elseif($status == 'EN REVISION')
                                        <option value="APROBADO">APROBADO</option>
                                        <option value="RECHAZADO">RECHAZADO</option>
                                        <option value="CULMINADO">CULMINADO</option>
                                        <optgroup label="Solo en caso de requerimiento financiero o materia prima">
                                            <option value="LIQUIDADO">LIQUIDADO</option>
                                            <option value="ENTREGADO">ENTREGADO</option>
                                        </optgroup>
                                    @elseif($status == 'APROBADO')
                                        <option value="CULMINADO">CULMINADO</option>
                                        <optgroup label="Solo en caso de requerimiento financiero o materia prima">
                                            <option value="LIQUIDADO">LIQUIDADO</option>
                                            <option value="ENTREGADO">ENTREGADO</option>
                                        </optgroup>
                                    @elseif($status == 'RECHAZADO')
                                        <option value="CULMINADO">CULMINADO</option>
                                    @elseif($status == 'LIQUIDADO' || $status == 'ENTREGADO')
                                        <option value="CULMINADO">CULMINADO</option>
                                    @else
                                        <option value="EN PROCESO">EN PROCESO</option>
                                        <option value="EN REVISION">EN REVISION</option>
                                        <option value="APROBADO">APROBADO</option>
                                        <option value="RECHAZADO">RECHAZADO</option>
                                        <option value="CULMINADO">CULMINADO</option>
                                        <optgroup label="Solo en caso de requerimiento financiero o materia prima">
                                            <option value="LIQUIDADO">LIQUIDADO</option>
                                            <option value="ENTREGADO">ENTREGADO</option>
                                        </optgroup>
                                    @endif


                                </select>
                                <label for="status">Estatus</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="2" placeholder="" required></textarea>
                                <label for="descripcion">Descripción</label>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAdAccion">Guardar</button>
            </div>
            </div><!--end .card -->
        </form>
    @endif

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
                    url:'{!! route('sistema.seguimiento.add') !!}',
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