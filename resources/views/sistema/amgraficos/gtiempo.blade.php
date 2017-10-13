@extends('layouts.blank')

@section('title')
    .:: Graficos - Intervalo de tiempo ::.
@endsection
@section('styles')
    <style>
        iframe{
            width: 100%;
            height: 100%;
            min-height: 250px ;
            margin: 0 auto;
            overflow-y: hidden ;
            border-top: 1px dotted #cccccc;
            border-right: 1px dotted #cccccc;
            border-left: 1px dotted #cccccc;
        }
        .overlay{
            bottom:0;
            left:0;
            width:100%;
            height:40px;
            position:absolute;
            margin: 0 auto;
        }
        iframe#ifeval{
            width: 100%;
            height: 100%;
            min-height: 80vh ;
            margin: 0 auto;
            overflow-y: hidden ;
            /*border-top: 1px solid #cccccc;*/
        }


        iframe#ampliar-frame{
            width: 100%;
            height: 100%;
            min-height: 85vh ;
            margin: 0 auto;
            overflow-y: hidden ;
            /*border-top: 1px solid #cccccc;*/
        }

    </style>
@endsection
@section('section-header')
    Graficos intervalo de tiempo
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card card-underline">
                <div class="card-head">
                    <ul class="nav nav-tabs pull-right" data-toggle="tabs">
                        <li class="active" ><a href="#fourth2">Evaluación</a></li>
                        <li><a href="#first2">Seguimiento</a></li>
                    </ul>
                    <header>Gráficos intervalo de tiempo ({{ \App\Http\Controllers\UtilidadesController::convertirFecha($request->f1) }} al {{ \App\Http\Controllers\UtilidadesController::convertirFecha($request->f2) }})</header>
                </div>
                <div class="card-body tab-content">

                    <div class="tab-pane active" id="fourth2">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <iframe frameborder="0" src="{!! route('sistema.gbarInt') !!}?cnd=eval&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifeval" ></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifeval','{!! route('sistema.gbarInt') !!}?cnd=eval&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbarInt') !!}?cnd=eval&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane" id="first2">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbarInt') !!}?cnd=edos&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifedos" ></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifedos','{!! route('sistema.gbarInt') !!}?cnd=edos&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbarInt') !!}?cnd=edos&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbarInt') !!}?cnd=div1&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifbar"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifbar','{!! route('sistema.gbarInt') !!}?cnd=div1&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbarInt') !!}?cnd=div1&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbarInt') !!}?cnd=div&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifbar2"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifbar2','{!! route('sistema.gbarInt') !!}?cnd=div&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbarInt') !!}?cnd=div&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbarInt') !!}?cnd=div2&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifdiv2"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifdiv2','{!! route('sistema.gbarInt') !!}?cnd=div2&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbarInt') !!}?cnd=div2&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.graficosInt') !!}?cnd=osol&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifosol"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifosol','{!! route('sistema.graficosInt') !!}?cnd=osol&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficosInt') !!}?cnd=osol&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbarInt') !!}?cnd=osol&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifbosol"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifbosol','{!! route('sistema.gbarInt') !!}?cnd=osol&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbarInt') !!}?cnd=osol&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.graficosInt') !!}?cnd=sac1&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifsac1"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifsac1','{!! route('sistema.graficosInt') !!}?cnd=sac1&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficosInt') !!}?cnd=sac1&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.graficosInt') !!}?cnd=sper&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifsper"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifsper','{!! route('sistema.graficosInt') !!}?cnd=sper&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficosInt') !!}?cnd=sper&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbarInt') !!}?cnd=banp&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifbanp"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifbanp','{!! route('sistema.gbarInt') !!}?cnd=banp&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbarInt') !!}?cnd=banp&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbarInt') !!}?cnd=smot&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifbsmot"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifbsmot','{!! route('sistema.gbarInt') !!}?cnd=smot&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbarInt') !!}?cnd=smot&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbarInt') !!}?cnd=fbs&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="iffbs" ></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('iffbs','{!! route('sistema.gbarInt') !!}?cnd=fbs&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbarInt') !!}?cnd=fbs&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbarInt') !!}?cnd=fusd&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="iffusd" ></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('iffusd','{!! route('sistema.gbarInt') !!}?cnd=fusd&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbarInt') !!}?cnd=fusd&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.grfmpInt') !!}?cnd=tmpr&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifbmpr"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifbmpr','{!! route('sistema.grfmpInt') !!}?cnd=tmpr&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.grfmpInt') !!}?cnd=tmpr&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.graficosInt') !!}?cnd=sac2&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifsac2"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifsac2','{!! route('sistema.graficosInt') !!}?cnd=sac2&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficosInt') !!}?cnd=sac2&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.graficosInt') !!}?cnd=esec&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifesec"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifesec','{!! route('sistema.graficosInt') !!}?cnd=esec&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficosInt') !!}?cnd=esec&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                    <iframe frameborder="0" src="{!! route('sistema.gbarInt') !!}?cnd=eseg&f1={{ $request->f1 }}&f2={{ $request->f2 }}" id="ifeseg"></iframe>
                                    <div class="overlay text-center">
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifeseg','{!! route('sistema.gbarInt') !!}?cnd=eseg&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Actualizar gráfico">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbarInt') !!}?cnd=eseg&f1={{ $request->f1 }}&f2={{ $request->f2 }}')" title="Ampliar gráfico">
                                            <i class="fa fa-external-link"></i>
                                        </button>
                                    </div>
                                </div>

                        </div>
                    </div>


                    <!--<div class="tab-pane" id="third2">

                    </div>-->
                </div>
            </div><!--end .card -->
        </div>
    </div>
    <!-- BEGIN SIMPLE MODAL MARKUP -->
    <div class="modal fade" id="modalAmpGrafico" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
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
                            <header>Gráfico intervalo de tiempo ({{ \App\Http\Controllers\UtilidadesController::convertirFecha($request->f1) }} al {{ \App\Http\Controllers\UtilidadesController::convertirFecha($request->f2) }})</header>
                        </div><!--end .card-head -->
                        <div class="card-body style-default-bright">
                            <iframe id="ampliar-frame" frameborder="0" ></iframe>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div>
                <!--<div class="modal-footer">
                    <button type="button" class="btn ink-reaction btn-primary" data-dismiss="modal">Aceptar</button>
                </div>-->

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END SIMPLE MODAL MARKUP -->


@endsection

@section('scripts')
    <script>
        $(function () {
            actGrafico = function(ifm, url){
                $('#'+ifm).attr('src', url);
            }
            ampliarGrafico = function(mdal, ifr, url){
                $('#'+ifr).attr('src', url);
                $('#'+mdal).modal('show');
            }
        })
    </script>
@endsection



