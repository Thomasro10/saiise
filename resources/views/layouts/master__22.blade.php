<!DOCTYPE html>
<html lang="en">
	<head>
		<title>@yield('title')</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/bootstrap.css?1422792965') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/materialadmin.css?1425466319') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/font-awesome.min.css?1422529194') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/material-design-iconic-font.min.css?1421434286') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/rickshaw/rickshaw.css?1422792967') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/morris/morris.core.css?1420463396') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/js/libs/sweetalert/sweetalert2.css?1420463396') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/jquery-ui/jquery-ui-theme.css?1423393666') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/bootstrap-datepicker/datepicker3.css?1424887858') }}" />


		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/js/libs/hcharts/maps/code/css/highcharts.css') }}" />

		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/loader.css?1420463396') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/preloader.css?1420463396') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/main.css?1420463396') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/loader_1.css?1423393666') }}" />
		@yield('styles')

		<style>
			body::-webkit-scrollbar {
				width: 0.3em;
			}

			body::-webkit-scrollbar-track {
				-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
			}

			body::-webkit-scrollbar-thumb {
				background-color: lightgrey;
				outline: 1px solid slategrey;
			}

			.modal-xl {
				width: 90vw;
				max-width:1400px;
			}

			.grf{
				width: 100%;
				height: 100%;
				min-height: 500px;
			}

			.style-success-light {
				background-color: #d4fad6;
				/*border-color: #c5f7be;*/
				color: #000;
			}

		</style>
		<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="{{ URL::to('assets/js/libs/utils/html5shiv.js?1403934957') }}"></script>
		<script type="text/javascript" src="{{ URL::to('assets/js/libs/utils/respond.min.js?1403934956') }}"></script>

		<![endif]-->
	</head>
	<body class="menubar-hoverable header-fixed">
	<div class="env-loader">
		<div class="loader">
			<span class="block-1"></span>
			<span class="block-2"></span>
			<span class="block-3"></span>
			<span class="block-4"></span>
			<span class="block-5"></span>
			<span class="block-6"></span>
			<span class="block-7"></span>
			<span class="block-8"></span>
			<span class="block-9"></span>
			<span class="block-10"></span>
			<span class="block-11"></span>
			<span class="block-12"></span>
			<span class="block-13"></span>
			<span class="block-14"></span>
			<span class="block-15"></span>
			<span class="block-16"></span>
		</div>
	</div>
	<!-- Start Page Loading -->
	<div id="loader-wrapper">
		<div id="loader"></div>
		<div class="loader-section section-left"></div>
		<div class="loader-section section-right"></div>
	</div>
	@if (Auth::user()->vez_p == 0 )
		<br><br><br><br><br><br><br><br><br>
		<div class="row">
			<div class="col-sm-3">&nbsp;</div>
			<div class="col-sm-6 text-center">
				<button type="button" class="btn ink-reaction btn-block btn-raised btn-primary" onclick="cambiarClave()">
					Cambiar clave
				</button>
			</div>
			<div class="col-sm-3">&nbsp;</div>
		</div>


		<!-- data-toggle="modal" data-target="#modalReg" -->
	@else
	<!-- End Page Loading -->
		<!-- BEGIN HEADER-->
		<header id="header" >
			<div class="headerbar">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="headerbar-left">
					<ul class="header-nav header-nav-options">
						<li class="header-nav-brand" >
							<div class="brand-holder">
								<a href="{{ URL::to('/') }}">
									<span class="text-lg text-bold text-primary">SAIISE</span>
								</a>
							</div>
						</li>
						<li>
							<a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
								<i class="fa fa-bars"></i>
							</a>
						</li>
					</ul>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="headerbar-right"><!--end .dropdown-menu --><!--end .header-nav-options -->
					<ul class="header-nav header-nav-profile">
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
								<img src="{{ URL::to('assets/img/avatar1.jpg?1403934956') }}" alt="" />
								<span class="profile-info">
									{{ Auth::user()->nombre }}
									<small>{{ \App\Http\Controllers\UtilidadesController::getRol(Auth::user()->rol) }}</small>
								</span>
							</a>
							<ul class="dropdown-menu animation-dock">
								<li class="dropdown-header">Config</li>
								{{--<li><a href="{{ URL::to('html/pages/profile.html') }}">My profile</a></li>--}}
								<li><a href="javascript:void(0);" onclick="cambiarClave()"><i class="md fa fa-key"></i> Cambiar clave</a></li>
								<li><a href="javascript:void(0);" onclick="logout()"><i class="glyphicon glyphicon-log-out"></i> Salir</a></li>
							</ul><!--end .dropdown-menu -->
						</li><!--end .dropdown -->
				  </ul><!--end .header-nav-profile -->
					<!--end .header-nav-toggle -->
			  </div><!--end #header-navbar-collapse -->
			</div>
		</header>
		<!-- END HEADER-->

		<!-- BEGIN BASE-->
	<div id="base">



			<!-- BEGIN CONTENT-->
		<div id="content">
			<section>
			<div class="section-header">
				<ol class="breadcrumb">
					<li class="active">@yield('section-header')</li>
				</ol>
			</div>
			@yield('content')
			</section>
		</div>
			<!-- END CONTENT -->

			<!-- BEGIN MENUBAR-->
	  <div id="menubar" class="menubar-inverse ">
				<div class="menubar-fixed-panel">
					<div>
						<a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
							<i class="fa fa-bars"></i>
						</a>
					</div>
					<div class="expanded">
						<a href="{{ URL::to('/') }}">
							<span class="text-lg text-bold text-primary ">SAIEER</span>
						</a>
					</div>
				</div>
				<div class="menubar-scroll-panel">

					<!-- BEGIN MAIN MENU -->
					<ul id="main-menu" class="gui-controls">

						<!-- BEGIN DASHBOARD -->
						<li>
							<a href="{{ URL::to('/') }}" @if(empty(Request::segment(1))) class="active" @endif>
								<div class="gui-icon"><i class="md md-home"></i></div>
								<span class="title">Inicio</span>
							</a>
						</li><!--end /menu-li -->
						<!-- END DASHBOARD -->

						@if(Auth::user()->rol != 5)
						<!-- BEGIN Requerimientos -->
						<li class="gui-folder @if( Request::segment(1) == 'empresas' ) active expanded @endif">
							<a>
								<div class="gui-icon"><i class="fa fa-building"></i></div>
								<span class="title">Empresas</span>
							</a>
							<!--start submenu -->
							<ul>
								<li @if(Request::segment(1) == 'empresas') class="active expanded" @endif><a href="{!! route('sistema.empresas') !!}" ><span class="title">Operaciones</span></a></li>
							</ul><!--end /submenu -->
						</li><!--end /menu-li -->
						<!-- END TABLES -->
						<!-- BEGIN Encuestas -->
						@if (Auth::user()->rol != 2 &&  Auth::user()->rol != 4 )
						<li class="gui-folder @if( Request::segment(1) == 'encuestas' ) active expanded @endif">
							<a>
								<div class="gui-icon"><i class="fa fa-file-text"></i></div>
								<span class="title">Información base</span>
							</a>
							<!--start submenu -->
							<ul>
								<li @if(Request::segment(1) == 'encuestas') class="active expanded" @endif><a href="{!! route('sistema.encuestas') !!}" ><span class="title">Operaciones</span></a></li>
							</ul><!--end /submenu -->
						</li><!--end /menu-li -->
						<!-- END TABLES -->
						<li class="gui-folder @if( Request::segment(1) == 'finanzas' ) active expanded @endif">
							<a>
								<div class="gui-icon"><i class="fa fa-money"></i></div>
								<span class="title">Req. de Financiamiento</span>
							</a>
							<!--start submenu -->
							<ul>
								<li @if(Request::segment(1) == 'finanzas') class="active expanded" @endif><a href="{!! route('sistema.finanzas') !!}" ><span class="title">Operaciones</span></a></li>
							</ul><!--end /submenu -->
						</li><!--end /menu-li -->
						<!-- END TABLES -->
						@endif
						@endif
						@if (Auth::user()->rol != 30  )
						<!-- BEGIN Materias primas -->
						<li class="gui-folder @if( Request::segment(1) == 'solicitudes' || Request::segment(1) == 'permisologia' || Request::segment(1) == 'mprima') active expanded @endif">
							<a>
								<div class="gui-icon"><i class="fa fa-folder"></i></div>
								<span class="title">Requerimientos / Solicitudes</span>
							</a>
							<!--start submenu -->
							<ul>
								<li @if(Request::segment(1) == 'solicitudes') class="active expanded" @endif><a href="{!! route('sistema.solicitudes') !!}" ><span class="title">Req / Solicitud</span></a></li>
								@if(Auth::user()->rol != 5)
								<li @if(Request::segment(1) == 'mprima') class="active expanded" @endif><a href="{!! route('sistema.mprima') !!}" ><span class="title">Detalle Materia prima</span></a></li>
								<li @if(Request::segment(1) == 'permisologia') class="active expanded" @endif><a href="{!! route('sistema.permisologia') !!}" ><span class="title">Detalle Permisología</span></a></li>
								@endif
							</ul><!--end /submenu -->
						</li><!--end /menu-li -->
						<!-- END TABLES -->
						<!-- BEGIN Materias primas -->
						@if(Auth::user()->rol != 5)
						<li class="gui-folder @if( Request::segment(1) == 'acciones' || Request::segment(1) == 'seguimiento' ) active expanded @endif">
								<a>
									<div class="gui-icon"><i class="fa fa-check-square-o"></i></div>
									<span class="title">Acciones</span>
								</a>
								<!--start submenu -->
								<ul>
									<li @if(Request::segment(1) == 'acciones') class="active expanded" @endif><a href="{!! route('sistema.acciones') !!}" ><span class="title">Acciones</span></a></li>
									<li @if(Request::segment(1) == 'seguimiento') class="active expanded" @endif><a href="{!! route('sistema.seguimiento') !!}" ><span class="title">Seguimiento</span></a></li>
								</ul><!--end /submenu -->
							</li><!--end /menu-li -->
						@endif
							<!-- END TABLES -->
					    @endif
					    @if (Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 3 || Auth::user()->rol == 4 || Auth::user()->rol == 5  )

					<!-- BEGIN Materias primas-->
						<li class="gui-folder @if( Request::segment(1) == 'reportes' ) active expanded @endif">
							<a>
								<div class="gui-icon"><i class="glyphicon glyphicon-list-alt"></i></div>
								<span class="title">Reportes</span>
							</a>
							<!--start submenu-->
							<ul>
								<li @if(Request::segment(1) == 'reportes') class="active expanded" @endif><a href="{!! route('sistema.reportes') !!}" ><span class="title">Reportes</span></a></li>
								<!--<li @if(Request::segment(1) == 'mprima') class="active expanded" @endif><a href="{!! route('sistema.mprima') !!}" ><span class="title">Detalle Materia prima</span></a></li>
								<li @if(Request::segment(1) == 'permisologia') class="active expanded" @endif><a href="{!! route('sistema.permisologia') !!}" ><span class="title">Detalle Permisología</span></a></li>-->
							</ul><!--end /submenu -->
						</li><!--end /menu-li-->
						<!-- END TABLES -->
					    @endif

						<!-- BEGIN USUARIOS -->
					    @if (Auth::user()->rol == 10 || Auth::user()->rol == 1 || Auth::user()->rol == 4)
						<li class="gui-folder @if( Request::segment(1) == 'usuarios' || Request::segment(1) == 'logs') active expanded @endif">
							<a>
								<div class="gui-icon"><i class="fa fa-cogs"></i></div>
								<span class="title">Configuración</span>
							</a>
							<!--start submenu -->
							<ul>
								@if (Auth::user()->rol == 10 || Auth::user()->rol == 1 )
								<li @if(Request::segment(1) == 'usuarios') class="active expanded" @endif><a href="{!! route('sistema.usuarios') !!}" ><span class="title">Usuarios</span></a></li>
								@endif
								@if (Auth::user()->rol == 10 || Auth::user()->rol == 4 )
								<li @if(Request::segment(1) == 'logs') class="active expanded" @endif><a href="{!! route('sistema.logs') !!}" ><span class="title">Logs</span></a></li>
							    @endif
							</ul><!--end /submenu -->
						</li><!--end /menu-li -->
						<!-- END TABLES -->
						@endif
						<!-- BEGIN DASHBOARD -->
						<li>
							<a href="javascript:void(0)" onclick="logout()" >
								<div class="gui-icon"><i class="glyphicon glyphicon-log-out"></i></div>
								<span class="title">Salir</span>
							</a>
						</li><!--end /menu-li -->
						<!-- END DASHBOARD -->


					</ul><!--end .main-menu -->
					<!-- END MAIN MENU -->

					<div class="menubar-foot-panel">
						<small class="no-linebreak hidden-folded">
							<span class="opacity-75">Copyright &copy; 2017</span> <strong><a href="mailto:jesus.antonio.gil.16@gmail.com">Lcdo. Inf. Jesús Gil</a></strong>
						</small>
					</div>
				</div><!--end .menubar-scroll-panel-->
		</div><!--end #menubar-->
		<!-- END MENUBAR -->

		<!-- BEGIN OFFCANVAS RIGHT --><!--end .offcanvas-->
		<!-- END OFFCANVAS RIGHT -->
	  </div><!--end #base-->
		<!-- END BASE -->
    @endif

	<!-- BEGIN FORM MODAL MARKUP -->
	<div class="modal fade" id="modalCambiarClave" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<form class="form form-validate" role="form" id="formCambiar" novalidate >
						<input type="hidden" name="_token" value="{{ Session::token() }}">
						<input type="hidden" name="id" value="{{ Auth::user()->id }}">
						@if (Auth::user()->vez_p == 0 )
							<input type="hidden" name="redirec" id="redirec" value="redirec">
						@endif
						<div class="card">
							<div class="card-head style-primary">
								<div class="tools">
									<div class="btn-group">
										<a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
									</div>
								</div>
								<header>Cambiar clave</header>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<input type="password" class="form-control" id="pass1" name="pass1" required>
											<label for="pass1">Nueva clave</label>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<input type="password" class="form-control" id="pass2" name="pass2" required data-rule-equalto="#pass1">
											<label for="pass2">Repita la clave</label>
										</div>
									</div>
								</div>

							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
								<button type="button" class="btn btn-primary" id="btCambiar">Cambiar clave</button>
								<!--<input type="submit" class="btn btn-primary" value="Guardar">-->
							</div>
						</div><!--end .card -->
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- END FORM MODAL MARKUP -->
		<!-- BEGIN JAVASCRIPT -->
		<script src="{{ URL::to('assets/js/libs/jquery/jquery-1.11.2.min.js') }}"></script>
		<script src="{{ URL::to('assets/js/libs/jquery/jquery-migrate-1.2.1.min.js') }}"></script>
		<script src="{{ URL::to('assets/js/libs/bootstrap/bootstrap.min.js') }}"></script>
		<script src="{{ URL::to('assets/js/libs/spin.js/spin.min.js') }}"></script>
		<script src="{{ URL::to('assets/js/libs/autosize/jquery.autosize.min.js') }}"></script>
		<script src="{{ URL::to('assets/js/libs/sweetalert/sweetalert2.min.js') }}"></script>
	    <script src="{{ URL::to('assets/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
	    <script src="{{ URL::to('assets/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    	<script src="{{ URL::to('assets/js/libs/jquery-validation/dist/localization/messages_es.js') }}"></script>
        <script src="{{ URL::to('assets/js/libs/mask_plugin/src/jquery.mask.js') }}"></script>



	    <script src="{{ URL::to('assets/js/libs/hcharts/maps/code/highcharts.js') }}"></script>
	    <script src="{{ URL::to('assets/js/libs/hcharts/maps/code/modules/exporting.js') }}"></script>
	    <script src="{{ URL::to('assets/js/libs/jquery-ui/jquery-ui.min.js') }}"></script>
	    <!--<script src="{{ URL::to('assets/js/libs/jquery-ui/datep_es.js') }}"></script>-->

	    <!--<script src="{{ URL::to('assets/js/libs/hcharts/maps/code/highmaps.js') }}"></script>-->

	<script src="{{ URL::to('assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>



	<script src="{{ URL::to('assets/js/libs/jquery-knob/jquery.knob.min.js') }}"></script>
		<script src="{{ URL::to('assets/js/libs/sparkline/jquery.sparkline.min.js') }}"></script>
		<script src="{{ URL::to('assets/js/libs/nanoscroller/jquery.nanoscroller.min.js') }}"></script>
		<script src="{{ URL::to('assets/js/libs/d3/d3.min.js') }}"></script>
		<script src="{{ URL::to('assets/js/libs/d3/d3.v3.js') }}"></script>
		<script src="{{ URL::to('assets/js/libs/rickshaw/rickshaw.min.js') }}"></script>
		<script src="{{ URL::to('assets/js/core/source/App.js') }}"></script>
		<script src="{{ URL::to('assets/js/core/source/AppNavigation.js') }}"></script>
		<script src="{{ URL::to('assets/js/core/source/AppOffcanvas.js') }}"></script>
		<script src="{{ URL::to('assets/js/core/source/AppCard.js') }}"></script>
		<script src="{{ URL::to('assets/js/core/source/AppForm.js') }}"></script>
		<script src="{{ URL::to('assets/js/core/source/AppNavSearch.js') }}"></script>
		<script src="{{ URL::to('assets/js/core/source/AppVendor.js') }}"></script>
		<script src="{{ URL::to('assets/js/core/demo/Demo.js') }}"></script>
	    <script src="{{ URL::to('assets/js/libs/modernizr/modernizr-custom.js') }}"></script>
		<!--<script src="{{-- URL::to('assets/js/libs/mask_plugin/src/jquery.mask.js') --}}"></script> -->
		@yield('scripts')
		<script>
			$(document).ajaxStart(function() {
				$(".env-loader").show();
			}).ajaxStop(function() {
				$(".env-loader").hide();
			});

			$(window).load(function () {
				setTimeout(function () {
					$('body').addClass('loaded');
				}, 200);
			});

			function logout(){
				swal({
					title: "¿Esta seguro que quiere salir del sistema?",
					type: "warning",
					cancelButtonText: "No",
					showCancelButton: true,
					confirmButtonText: "Si, estoy seguro",
					reverseButtons: true
				}).then(function () {
					$.ajax({
						type: "POST",
						url:'{!! route("sistema.salir") !!}',
						data: {"_token": "{{ csrf_token() }}"},
						success: function( data ) {
							location.href = "{!! route('sistema.acceso') !!}";
						}
					});
				});
			}
			$(function () {

                $('input[type="number"]').mask("#.##0,00", {reverse: true});


				if (!Modernizr.inputtypes.date) {
					//$('input[type=date]').datepicker({ dateFormat: 'yy-mm-dd' });
					$('input[type=date]').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
				}
				getEmpresa = function(id1, id2, url){
					id_elem = $("#"+id2);
					$( "#"+id1 ).autocomplete({
						source: url,
						minLength: 2,
						select: function( event, ui ) {
							id_elem.val(ui.item.id)
						}
					});
				}

				getSolicitud = function(id1, id2, url){
					id_elem = $("#"+id2);
					$( "#"+id1 ).autocomplete({
						source: url,
						minLength: 1,
						select: function( event, ui ) {
							id_elem.val(ui.item.id)
						}
					});
				}

				var fCClave = $("#formCambiar");
				cambiarClave = function(){
					fCClave.clearForm();
					$('#modalCambiarClave').modal('show')
				}

				fCClave.validate();
				$('#btCambiar').click(function(){
					if(fCClave.valid()){
						$.ajax({
							type: "POST",
							url:'{!! route("sistema.ccambiar") !!}',
							data: fCClave.serialize(),
							success: function( data ) {
								if(data.status == 1){
									swal(data.msg, "", "success");
									fCClave.clearForm();
									$("#modalCambiarClave").modal('hide');
									if($("#redirec").val()=='redirec'){
										location.href ='{!! URL::to('/') !!}'
									}
								}
								else{
									swal(data.msg, "", "error");
								}
							}
						});
					}
				})

				getMPrimaMedida = function(id1, url){
					$( "#"+id1 ).autocomplete({
						source: url,
						minLength: 1
					});
				}

			})


		</script>


		@stack('script')


		<!-- END JAVASCRIPT -->

	</body>
</html>
