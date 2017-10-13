@foreach($inv as $i)
            <div class="row">
                <div class="col-sm-12 "></di><a class="btn ink-reaction btn-floating-action btn-danger btn-sm pull-right" href="javascript:void(0)" title="Eliminar" onclick="eliminarInvVer('{{ $i->id }}')"><i class="fa fa-trash-o"></i></a></div>
            </div>
            <div class="row">
                <div class="col-sm-4">Requiere Financiamiento: <strong>{{ $i->financiamiento }}</strong></div>
                <div class="col-sm-4">Monto en BS: <strong>{{ number_format($i->montobs, 2, ",", ".") }}</strong></div>
                <div class="col-sm-4">Monto en USD: <strong>{{ number_format($i->montousd, 2, ",", ".") }}</strong></div>
            </div>
            <div class="row">
                <div class="col-sm-12">Uso del Financiamiento: <strong>{{ $i->uso }}</strong></div>
            </div>
            <div class="row">
                <div class="col-sm-6">Postura de compra de divisas en el Sistema DICOM: <strong>{{ $i->pdicom }}</strong></div>
                <div class="col-sm-6">Adjudicado en las subastas: <strong>{{ $i->sdicom }}</strong></div>
            </div>
            <div class="row">
                <div class="col-sm-6">Números de Subastas: <strong>{{ $i->nsubastas }}</strong></div>
                <div class="col-sm-6">Monto asignado USD: <strong>{{ number_format($i->asignacion, 2, ",", ".") }}</strong></div>
            </div>
            <div class="row">
                <div class="col-sm-12">Recibido financiamiento (Por ente o banco): <strong>{{ $i->rfinaciamiento }}</strong></div>
            </div>
            <div class="row">
                <div class="col-sm-6">Cartera dirigida: <strong>{{ $i->cartera }}</strong></div>
                <div class="col-sm-6">Monto financiado: <strong>{{ number_format($i->montofin, 2, ",", ".") }}</strong></div>
            </div>
            <div class="row">
                <div class="col-sm-12">Permisos, licencias, certificados y trámites: <strong>{{ $i->permisos }}</strong></div>
            </div>
            <script>
                eliminarInvVer = function(id){

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
                            url:'{!! route('sistema.visitas.inversion.del') !!}',
                            data: {"_token": "{{ csrf_token() }}", "id": id},
                            success: function( data ) {
                                if(data.status == 1){
                                    swal(data.msg, "", "success");
                                    $('#formAddVInv').modal('hide');
                                }
                                else{
                                    swal(data.msg, "", "error");
                                }
                            }
                        });
                    });

                }
            </script>
@endforeach

