@foreach($accion as $a)
    <div class="card">
        <div class="card-head card-head-xs style-primary-bright">
            @if($loop->last && (Auth::user()->rol ==10 || Auth::user()->rol ==1 || Auth::user()->rol == 4 || Auth::user()->rol ==2))
                <div class="tools">
                    <div class="btn-group">
                        <a class="btn btn-icon-toggle" href="javascript:void(0)" title="Eliminar accion" onclick="eliminarAccion('{{ $a->id }}')"><i class="fa fa-trash-o"></i></a>
                    </div>
                </div>
            @endif
            <header>Accion {{ ++$loop->index }}</header>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    Fecha: <b>{{ \App\Http\Controllers\UtilidadesController::convertirFecha($a->fecha) }}</b>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    Remitido a: <b>{{ $a->remitido_a }}</b>
                </div>
                <div class="col-sm-4">
                    Especifique: <b>{{ $a->ra_especifique }}</b>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    Forma de remisión: <b>{{ $a->ra_forma }}</b>
                </div>
                <div class="col-sm-4">
                    Especifique: <b>{{ $a->raf_especifique }}</b>
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
                url:'{!! route('sistema.acciones.del') !!}',
                data: {"_token": "{{ csrf_token() }}",'id_sol':'{{ $id_sol }}', "id": id},
                success: function( data ) {
                    if(data.status == 1){
                        swal(data.msg, "", "success");
                        recargaAccion({{ $id_sol }})
                    }
                    else{
                        swal(data.msg, "", "error");
                    }
                }
            });
        });

    }
</script>