
<div class="row">
    <div class="col-sm-6">
        @foreach($accion as $a)
            <div class="card">
                <div class="card-head card-head-xs style-primary-bright">
                    <header>Accion {{ ++$loop->index }}</header>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            Fecha: <b>{{ \App\Http\Controllers\UtilidadesController::convertirFecha($a->fecha) }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            Remitido a: <b>{{ $a->remitido_a }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            Forma de remisión: <b>{{ $a->ra_forma }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            Observación: <b>{{ $a->observacion }}</b>
                        </div>
                    </div>
                </div>
            </div><!--end .card -->
        @endforeach
    </div>
    <div class="col-sm-6">
        @foreach($seg as $s)
            <div class="card">
                <div class="card-head card-head-xs @if($s->status == 'EN REVISION') style-primary-light @elseif($s->status == 'EN PROCESO') style-primary @elseif($s->status == 'RECHAZADO') style-danger @elseif($s->status == 'APROBADO') style-success-light @elseif($s->status == 'CULMINADO') style-success @elseif($s->status == 'LIQUIDADO') style-accent-light @elseif($s->status == 'ENTREGADO') style-accent @endif ">
                    @if($loop->last && (Auth::user()->rol ==10 || Auth::user()->rol ==1 || Auth::user()->rol == 4 || Auth::user()->rol ==2))
                        <div class="tools">
                            <div class="btn-group">
                                <a class="btn btn-icon-toggle" href="javascript:void(0)" title="Eliminar accion" onclick="eliminarAccion('{{ $s->id }}')"><i class="fa fa-trash-o"></i></a>
                            </div>
                        </div>
                    @endif
                    <header>Actividad de seguimiento {{ ++$loop->index }}</header>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            Fecha: <b>{{ \App\Http\Controllers\UtilidadesController::convertirFecha($s->fecha) }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            Estatus: <b>{{ $s->status }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            Descripción: <b>{{ $s->descripcion }}</b>
                        </div>
                    </div>
                </div>
            </div><!--end .card -->
        @endforeach
    </div>

</div>

<script>
    eliminarAccion = function(id){

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
                url:'{!! route('sistema.seguimiento.del') !!}',
                data: {"_token": "{{ csrf_token() }}", "id": id},
                success: function( data ) {
                    if(data.status == 1){
                        swal(data.msg, "", "success");
                        recargaSeg({{ $id_sol }});
                        //$("#accVerForm").modal('hide');
                    }
                    else{
                        swal(data.msg, "", "error");
                    }
                }
            });
        });

    }


</script>