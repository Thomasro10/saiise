@extends('layouts.master')

@section('title')
    .:: Inicio ::.
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
    Inicio
@endsection

@section('content')

  @if (Auth::user()->rol == 30 )
    <div class="row">
        <div class="col-md-12">
            <h2>
                <span class="text-xxl">SAIISE</span>
            </h2>
            <h4>Sistema de Atención Integral a la Industria, Seguimiento y Evaluación</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

        </div>
    </div>
  @else
    <div class="row">
        <div class="col-md-12">
            <div class="card card-underline">
                <div class="card-head">
                    <ul class="nav nav-tabs pull-right" data-toggle="tabs">
                        <li class="active" ><a href="#fourth2">Evaluación</a></li>
                        <li><a href="#first2">Seguimiento</a></li>
                        @if (Auth::user()->rol != 2  )
                        <li><a href="#second2">Base</a></li>
                        <li><a href="#third2">Req. Financieros</a></li>
                        @endif
                    </ul>
                    <header>Gráficos</header>
                </div>
                <div class="card-body tab-content">

                    <div class="tab-pane active" id="fourth2">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <iframe frameborder="0" src="{!! route('sistema.gbar') !!}?cnd=eval" id="ifeval" ></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifeval','{!! route('sistema.gbar') !!}?cnd=eval')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbar') !!}?cnd=eval')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane" id="first2">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbar') !!}?cnd=edos" id="ifedos" ></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifedos','{!! route('sistema.gbar') !!}?cnd=edos')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbar') !!}?cnd=edos')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbar') !!}?cnd=div1" id="ifbar"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifbar','{!! route('sistema.gbar') !!}?cnd=div1')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbar') !!}?cnd=div1')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbar') !!}?cnd=div" id="ifbar2"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifbar2','{!! route('sistema.gbar') !!}?cnd=div')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbar') !!}?cnd=div')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbar') !!}?cnd=div2" id="ifdiv2"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifdiv2','{!! route('sistema.gbar') !!}?cnd=div2')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbar') !!}?cnd=div2')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=osol" id="ifosol"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifosol','{!! route('sistema.graficos') !!}?cnd=osol')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=osol')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbar') !!}?cnd=osol" id="ifbosol"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifbosol','{!! route('sistema.gbar') !!}?cnd=osol')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbar') !!}?cnd=osol')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=sac1" id="ifsac1"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifsac1','{!! route('sistema.graficos') !!}?cnd=sac1')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=sac1')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=sper" id="ifsper"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifsper','{!! route('sistema.graficos') !!}?cnd=sper')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=sper')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbar') !!}?cnd=banp" id="ifbanp"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifbanp','{!! route('sistema.gbar') !!}?cnd=banp')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbar') !!}?cnd=banp')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbar') !!}?cnd=smot" id="ifbsmot"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifbsmot','{!! route('sistema.gbar') !!}?cnd=smot')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbar') !!}?cnd=smot')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbar') !!}?cnd=fbs" id="iffbs" ></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('iffbs','{!! route('sistema.gbar') !!}?cnd=fbs')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbar') !!}?cnd=fbs')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.gbar') !!}?cnd=fusd" id="iffusd" ></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('iffusd','{!! route('sistema.gbar') !!}?cnd=fusd')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbar') !!}?cnd=fusd')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.grfmp') !!}?cnd=tmpr" id="ifbmpr"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifbmpr','{!! route('sistema.grfmp') !!}?cnd=tmpr')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.grfmp') !!}?cnd=tmpr')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=sac2" id="ifsac2"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifsac2','{!! route('sistema.graficos') !!}?cnd=sac2')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=sac2')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=esec" id="ifesec"></iframe>
                                <div class="overlay text-center">
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifesec','{!! route('sistema.graficos') !!}?cnd=esec')" title="Actualizar gráfico">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                    <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=esec')" title="Ampliar gráfico">
                                        <i class="fa fa-external-link"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                    <iframe frameborder="0" src="{!! route('sistema.gbar') !!}?cnd=eseg" id="ifeseg"></iframe>
                                    <div class="overlay text-center">
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifeseg','{!! route('sistema.gbar') !!}?cnd=eseg')" title="Actualizar gráfico">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.gbar') !!}?cnd=eseg')" title="Ampliar gráfico">
                                            <i class="fa fa-external-link"></i>
                                        </button>
                                    </div>
                                </div>

                        </div>
                    </div>
                    @if (Auth::user()->rol != 2  )
                        <div class="tab-pane" id="second2">
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=temp" id="iftemp"></iframe>
                                    <div class="overlay text-center">
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('iftemp','{!! route('sistema.graficos') !!}?cnd=temp')" title="Actualizar gráfico">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=temp')" title="Ampliar gráfico">
                                            <i class="fa fa-external-link"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=ntra" id="ifntra" ></iframe>
                                    <div class="overlay text-center">
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifntra','{!! route('sistema.graficos') !!}?cnd=ntra')" title="Actualizar gráfico">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=ntra')" title="Ampliar gráfico">
                                            <i class="fa fa-external-link"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=mtor" id="ifmtor"></iframe>
                                    <div class="overlay text-center">
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifmtor','{!! route('sistema.graficos') !!}?cnd=mtor')" title="Actualizar gráfico">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=mtor')" title="Ampliar gráfico">
                                            <i class="fa fa-external-link"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=aeco" id="ifaeco"></iframe>
                                    <div class="overlay text-center">
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifaeco','{!! route('sistema.graficos') !!}?cnd=aeco')" title="Actualizar gráfico">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=aeco')" title="Ampliar gráfico">
                                            <i class="fa fa-external-link"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=cope" id="ifcope"></iframe>
                                    <div class="overlay text-center">
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifcope','{!! route('sistema.graficos') !!}?cnd=cope')" title="Actualizar gráfico">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=cope')" title="Ampliar gráfico">
                                            <i class="fa fa-external-link"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=mpri" id="ifmpri"></iframe>
                                    <div class="overlay text-center">
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifmpri','{!! route('sistema.graficos') !!}?cnd=mpri')" title="Actualizar gráfico">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=mpri')" title="Ampliar gráfico">
                                            <i class="fa fa-external-link"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=maba" id="ifmaba"></iframe>
                                    <div class="overlay text-center">
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifmaba','{!! route('sistema.graficos') !!}?cnd=maba')" title="Actualizar gráfico">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=maba')" title="Ampliar gráfico">
                                            <i class="fa fa-external-link"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=rubr" id="ifrubr"></iframe>
                                    <div class="overlay text-center">
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifrubr','{!! route('sistema.graficos') !!}?cnd=rubr')" title="Actualizar gráfico">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary"  onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=rubr')" title="Ampliar gráfico">
                                            <i class="fa fa-external-link"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="third2">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=div" id="ifdiv"></iframe>
                                    <div class="overlay text-center">
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifdiv','{!! route('sistema.graficos') !!}?cnd=div')" title="Actualizar gráfico">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=div')" title="Ampliar gráfico">
                                            <i class="fa fa-external-link"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=exp" id="ifexp" ></iframe>
                                    <div class="overlay text-center">
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifexp','{!! route('sistema.graficos') !!}?cnd=exp')" title="Actualizar gráfico">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=exp')" title="Ampliar gráfico">
                                            <i class="fa fa-external-link"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <iframe frameborder="0" src="{!! route('sistema.graficos') !!}?cnd=rfi" id="ifrfi"></iframe>
                                    <div class="overlay text-center">
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="actGrafico('ifrfi','{!! route('sistema.graficos') !!}?cnd=rfi')" title="Actualizar gráfico">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <button type="button" class="btn ink-reaction btn-icon-toggle btn-xs btn-primary" onclick="ampliarGrafico('modalAmpGrafico', 'ampliar-frame','{!! route('sistema.graficos') !!}?cnd=rfi')" title="Ampliar gráfico">
                                            <i class="fa fa-external-link"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


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
                            <header>Gráfico</header>
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
  @endif


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



