<html lang="en">
<head>
    <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-default/libs/dropzone/material.css?1424887864') }}" />
    <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/js/libs/sweetalert/sweetalert2.css?1420463396') }}" />
<style>
    .dropzone {
        width: 100% !important; margin:  0 auto !important; min-height: 150px !important;
    }
    table{
        font-size: 12px; border-collapse: collapse; font-family: Arial, Verdana, sans-serif;
    }
    .cell{
        border: 1px #ccc solid; border-collapse: collapse !important; padding: 6px; margin: 0;
    }
    .cell-title{
        background-color: #A31313; color: #ffffff; border: 1px #A31313 solid; border-collapse: collapse !important; padding: 6px; margin: 0; font-size: 14px; font-weight: bold; text-align: center;
    }
    .cell-subtitle{
        background-color: #A31313; color: #ffffff; border: 1px #A31313 solid; border-collapse: collapse !important; padding: 6px; margin: 0; font-size: 12px; font-weight: bold; text-align: center;
    }
</style>
</head>
<body>
<div id="header">
    <img src="{{ asset('assets/img/cintillo.png') }}" width="100%">
    <hr>
</div>

<div id="content">
    @foreach($visita as $vis)
    <table width="100%" >
        <tbody>
        <tr>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
        </tr>
        <tr>
            <td align="center" colspan="12"><h2>FICHA INFORMATIVA</h2></td>
        </tr>
        <tr>
            <td colspan="6" class="cell">Tiempo de operatividad de la empresa: <b>{{ $vis->operatividad  }}</b></td>
            <td colspan="3" class="cell">Fecha: <b>{{ $vis->fecha }}</b></td>
            <td colspan="3" class="cell">CIIU/CAEV: <b>{{ $vis->ciiu }}</b></td>
        </tr>
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <tr>
            <td colspan="12" class="cell-title">INFORMACIÓN DE LA EMPRESA</td>
        </tr>
        <tr>
            <td colspan="6" class="cell">Nombre de la Empresa: <b>{{ $vis->empresa }}</b></td>
            <td colspan="6" class="cell">RIF: <b>{{ $vis->rif }}</b></td>
        </tr>
        <tr>
            <td colspan="4" class="cell">Estado: <b>{{ $vis->edo }}</b></td>
            <td colspan="4" class="cell">Municipio: <b>{{ $vis->mcpio }}</b></td>
            <td colspan="4" class="cell">Parroquia: <b>{{ $vis->pquia }}</b></td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Dirección: <b>{{ $vis->direccion }}</b></td>
        </tr>
        <tr>
            <td colspan="4" class="cell">Tipo de empresa: <b>{{ $vis->tipo_emp }}</b> </td>
            <td colspan="4" class="cell">Número de trabajadores: <b>{{ $vis->trabajadores }} @if($vis->tnum =! 0 )  ({{ $vis->tnum }})</b>@endif</td>
            <td colspan="4" class="cell">Sector actividad industrial: <b>{{ $vis->sector }}</b> </td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Servicios de la Parcela: <b>{{ $vis->servicios }}</b></td>
        </tr>
        <tr>
            <td colspan="3" class="cell">Presidente: <b>{{ $vis->contacto }}</b> </td>
            <td colspan="3" class="cell">C.I.: <b>{{ number_format($vis->ci_cont, 0, ",", ".") }}</b></td>
            <td colspan="3" class="cell">Telf: <b>{{ $vis->telf }}</b> </td>
            <td colspan="3" class="cell">Email: <b>{{ $vis->email }}</b> </td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Objeto de la empresa: <b>{{ $vis->objeto }}</b></td>
        </tr>
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <tr>
            <td colspan="12" class="cell-title">INFORMACIÓN DE LA PRODUCCIÓN</td>
        </tr>
        <tr>
            <td colspan="12" class="cell">
                <!-- produccion-->
                <table width="100%" >
                  <tbody>
                   <tr>
                       <td class="cell-subtitle" width="12.5%">Producto</td>
                       <td class="cell-subtitle" width="12.5%">Código arancelario</td>
                       <td class="cell-subtitle" width="12.5%">Medida</td>
                       <td class="cell-subtitle" width="12.5%">Capacidad Instalada (mes)</td>
                       <td class="cell-subtitle" width="12.5%">Capacidad utilizada (mes)</td>
                       <td class="cell-subtitle" width="12.5%">Producción anual (año ant)</td>
                       <td class="cell-subtitle" width="12.5%">Producción Actual (mes)</td>
                       <td class="cell-subtitle" width="12.5%">Producción meta (año en curso)</td>
                   </tr>
                   @if(count($vprod) != 0)
                   @foreach($vprod as $vp)
                   <tr>
                       <td class="cell">{{ $vp->producto }}</td>
                       <td class="cell">{{ $vp->cod_aran }}</td>
                       <td class="cell">{{ $vp->medida }}</td>
                       <td class="cell">{{ number_format($vp->cinstalada, 2, ",", ".") }}</td>
                       <td class="cell">{{ number_format($vp->coperativa, 2, ",", ".") }}</td>
                       <td class="cell">{{ number_format($vp->prodaant, 2, ",", ".") }}</td>
                       <td class="cell">{{ number_format($vp->prodact, 2, ",", ".") }}</td>
                       <td class="cell">{{ number_format($vp->prodmeta, 2, ",", ".") }}</td>
                   </tr>
                   @endforeach
                   @endif
                  </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Líneas de producción: <b>{{ $vis->l_prod }}</b></td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Nudos críticos para la producción: <b>{{ $vis->nc_prod}}</b></td>
        </tr>
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <tr>
            <td colspan="12" class="cell-title">INFORMACIÓN DE LA MATERIA PRIMA</td>
        </tr>
        <tr>
            <td colspan="12" class="cell">
                <!-- materia prima-->
                <table width="100%" >
                    <tbody>
                    <tr>
                        <td class="cell-subtitle" width="16.6%">Producto</td>
                        <td class="cell-subtitle" width="16.6%">Proveedor</td>
                        <td class="cell-subtitle" width="16.6%">Código arancelario</td>
                        <td class="cell-subtitle" width="16.6%">Medida</td>
                        <td class="cell-subtitle" width="16.6%">Cantidad requerida (mes)</td>
                        <td class="cell-subtitle" width="16.6%">Cantidad Disponible</td>
                    </tr>
                    @if(count($vmpri) != 0)
                    @foreach($vmpri as $vm)
                    <tr>
                        <td class="cell">{{ $vm->producto }}</td>
                        <td class="cell">{{ $vm->proveedor }}</td>
                        <td class="cell">{{ $vm->cod_aran }}</td>
                        <td class="cell">{{ $vm->medida }}</td>
                        <td class="cell">{{ number_format($vm->creq, 2, ",", ".") }}</td>
                        <td class="cell">{{ number_format($vm->cdis, 2, ",", ".") }}</td>
                    </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Nudos críticos para la adquisición de materia prima: <b>{{ $vis->nc_mprima }}</b></td>
        </tr>
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <tr>
            <td colspan="12" class="cell-title">INFORMACIÓN DE LA COMERCIALIZACIÓN</td>
        </tr>
        <tr>
            <td colspan="12" class="cell">
                <!-- comercializacion-->
                <table width="100%" >
                    <tbody>
                    <tr>
                        <td class="cell-subtitle" width="11.1%">Producto</td>
                        <td class="cell-subtitle" width="11.1%">Código arancelario</td>
                        <td class="cell-subtitle" width="11.1%">Mercado Interno</td>
                        <td class="cell-subtitle" width="11.1%">Exportación</td>
                        <td class="cell-subtitle" width="11.1%">Precio Bs.</td>
                        <td class="cell-subtitle" width="11.1%">Venta Nacional (año ant)</td>
                        <td class="cell-subtitle" width="11.1%">Venta Nacional estimación (año act)</td>
                        <td class="cell-subtitle" width="11.1%">Exportación USD (año ant)</td>
                        <td class="cell-subtitle" width="11.1%">Exportación estimación (año act)$</td>
                    </tr>
                    @if(count($vcom) != 0)
                    @foreach($vcom as $vc)
                    <tr>
                        <td class="cell">{{ $vc->producto }}</td>
                        <td class="cell">{{ $vc->cod_aran }}</td>
                        <td class="cell">{{ $vc->minterno }}</td>
                        <td class="cell">{{ $vc->exportacion}}</td>
                        <td class="cell">{{ number_format($vc->preciobs, 2, ",", ".") }}</td>
                        <td class="cell">{{ number_format($vc->ventanac, 2, ",", ".") }}</td>
                        <td class="cell">{{ number_format($vc->ventanacest, 2, ",", ".") }}</td>
                        <td class="cell">{{ number_format($vc->exportacionusd, 2, ",", ".") }}</td>
                        <td class="cell">{{ number_format($vc->exportacionestusd, 2, ",", ".") }}</td>
                    </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Destino de colocación de la producción principales clientes: <b>{{ $vis->pclientes }}</b> </td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Destino de colocación de la producción por estado:  <b>{{ $vis->pedo }}</b> </td>
        </tr>
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <tr>
            <td colspan="12" class="cell-title">REQUERIMIENTOS DE INVERSIÓN Y PERMISOS</td>
        </tr>
        @foreach($vinvp as $vv)
        <tr>
            <td colspan="4" class="cell">Requiere Financiamiento: <b>{{ $vv->financiamiento}}</b></td>
            <td colspan="4" class="cell">Monto en Bs.: <b>{{ number_format($vv->montobs, 2, ",", ".") }}</b></td>
            <td colspan="4" class="cell">Monto en USD: <b>{{ number_format($vv->montousd, 2, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Uso del Financiamiento: <b>{{ $vv->uso }}</b></td>
        </tr>
        <tr>
            <td colspan="6" class="cell">Postura de compra de divisas en el Sistema DICOM: <b>{{ $vv->pdicom }}</b></td>
            <td colspan="6" class="cell">Adjudicado en la subastas: <b>{{ $vv->sdicom }}</b></td>
        </tr>
        <tr>
            <td colspan="6" class="cell">Números de Subasta: <b>{{ $vv->nsubastas }}</b></td>
            <td colspan="6" class="cell">Monto asignado USD: <b>{{ number_format($vv->asignacion, 2, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Recibido financiamiento (ente): <b>{{ $vv->rfinaciamiento }}</b></td>
        </tr>
        <tr>
            <td colspan="6" class="cell">Cartera dirigida: <b>{{ $vv->cartera }}</b></td>
            <td colspan="6" class="cell">Monto financiado: <b>{{ number_format($vv->montofin, 2, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Permisos, licencias, certificados y trámites: <b>{{ $vv->permisos }}</b></td>
        </tr>
        @endforeach
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Observaciones generales: <b>{{ $vis->observacion }}</b></td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Describa el Proceso productivo (paso a paso): <b>{{ $vis->pproductivo }}</b> </td>
        </tr>
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <tr>
            <td colspan="12" class="cell-title">FOTOS</td>
        </tr>
        <tr>
            <td colspan="6" class="cell">
                @if(empty($vis->foto1))
                    <div id="dfoto1" class="dropzone"></div>
                @else
                    <img src="{{ asset('imagenes/'.$vis->foto1) }}" width="100%" class="foto"  data-foto="1" title="Click para eliminar">
                @endif
            </td>
            <td colspan="6" class="cell">
                @if(empty($vis->foto2))
                    <div id="dfoto2" class="dropzone"></div>
                @else
                    <img src="{{ asset('imagenes/'.$vis->foto2) }}" width="100%" class="foto"  data-foto="2" title="Click para eliminar">
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="6" class="cell">
                @if(empty($vis->foto3))
                    <div id="dfoto3" class="dropzone"></div>
                @else
                    <img src="{{ asset('imagenes/'.$vis->foto3) }}" width="100%" class="foto"  data-foto="3" title="Click para eliminar">
                @endif
            </td>
            <td colspan="6" class="cell">
                @if(empty($vis->foto4))
                    <div id="dfoto4" class="dropzone"></div>
                @else
                    <img src="{{ asset('imagenes/'.$vis->foto4) }}" width="100%" class="foto" data-foto="4" title="Click para eliminar">
                @endif
            </td>
        </tr>
        </tbody>
    </table>
    @endforeach
</div>

<div id="footer">
    <hr>
    <table width="100%" border="0">
        <tbody>
        <tr>
            <td align="center">
                Dirección de Seguimiento y Evaluación a la Industria<br>
                Sistema de Atención Integral a la Industria, Seguimiento y Evaluacion (SAIISE)
            </td>
        </tr>
        </tbody>
    </table>
</div>
<script src="{{ URL::to('assets/js/libs/jquery/jquery-1.11.2.min.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/dropzone_new/dropzone.js') }}"></script>
<script src="{{ URL::to('assets/js/libs/sweetalert/sweetalert2.min.js') }}"></script>
<script>
    $(function () {
        Dropzone.autoDiscover = false;
        subirFoto('dfoto1', '{{ $vis->id }}', 'foto1');
        subirFoto('dfoto2', '{{ $vis->id }}', 'foto2');
        subirFoto('dfoto3', '{{ $vis->id }}', 'foto3');
        subirFoto('dfoto4', '{{ $vis->id }}', 'foto4');

        $('.foto').click(function () {
            switch ($(this).data('foto')){
                case 1:
                    eliminarFoto('{{ $vis->id }}', 'foto1')
                break;
                case 2:
                    eliminarFoto('{{ $vis->id }}', 'foto2')
                break;
                case 3:
                    eliminarFoto('{{ $vis->id }}', 'foto3')
                break;
                case 4:
                    eliminarFoto('{{ $vis->id }}', 'foto4')
                break;
            }
        })

    })

     function subirFoto(divId, vis_id, cnd){
        $("#"+divId).dropzone({
            url: "{{ route('sistema.visitas.upl') }}",
            params: {"_token": "{{ csrf_token() }}", "id": vis_id, "cnd" : cnd },
            acceptedFiles: "image/jpg,image/jpeg,image/png,image/gif",
            maxFileSize: 2,
            thumbnailHeight: 50,
            thumbnailWidth: 50,
            previewTemplate: "<div class=\"pic dz-preview dz-file-preview\">\n  <div class=\"dz-image\"><img data-dz-thumbnail /></div>\n  <div class=\"dz-details\">\n    <div class=\"dz-size\"><span data-dz-size></span></div>\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n  </div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n  <div class=\"dz-success-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Check</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n<path d=\"M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" stroke-opacity=\"0.198794158\" stroke=\"#FFFFFF\" fill-opacity=\"0.816519475\" fill=\"#32A336\" sketch:type=\"MSShapeGroup\"></path>\n      </g>\n    </svg>\n  </div>\n  <div class=\"dz-error-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Error</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n<g id=\"Check-+-Oval-2\" sketch:type=\"MSLayerGroup\" stroke=\"#FFFFFF\" stroke-opacity=\"0.198794158\" fill=\"#ff0000\" fill-opacity=\"0.816519475\">\n  <path d=\"M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" sketch:type=\"MSShapeGroup\"></path>\n</g>\n      </g>\n    </svg>\n  </div>\n</div>",
            RemoveLinkTemplate: "<div class=\"remove\" data-dz-remove><i class=\"icon-cross\"></i></div>",
            init: function() {
                this.on("success", function(file, response) {
                    alert(response.msg);
                }),
                    this.on("complete", function(file) {
                        if (file.previewElement) {
                            return file.previewElement.classList.add("dz-success"),
                                $(function(){
                                    setTimeout(function(){
                                        $('.dz-success').fadeOut('slow');
                                        parent.$('#iframeFicha').attr('src', '{{ route('sistema.visitas.view') }}?id={{ $vis->id }}');
                                    },1500);
                                });
                        }
                    });
            }
        });
     }

     function eliminarFoto(vis_id, cnd){
        swal({
            title: "¿Esta seguro que quiere borrar esta imagen?",
            text: "Esta acción no puede ser desecha",
            type: "warning",
            cancelButtonText: "No",
            showCancelButton: true,
            confirmButtonText: "Si, estoy seguro",
            reverseButtons: true
        }).then(function (text) {
            $.ajax({
                type: "POST",
                url:'{!! route('sistema.visitas.delfoto') !!}',
                data: {"_token": "{{ csrf_token() }}", "id": vis_id, 'cnd': cnd},
                success: function( data ) {
                    if(data.status == 1){
                        swal(data.msg, "", "success");
                        parent.$('#iframeFicha').attr('src', '{{ route('sistema.visitas.view') }}?id={{ $vis->id }}');
                    }
                    else{
                        swal(data.msg, "", "error");
                    }
                }
            });
        });
    }
</script>
</body>
</html>