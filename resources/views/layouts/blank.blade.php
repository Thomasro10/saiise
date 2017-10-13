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



	@yield('content')


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
	    <script src="{{ URL::to('assets/js/libs/jquery-ui/datep_es.js') }}"></script>

	    <!--<script src="{{ URL::to('assets/js/libs/hcharts/maps/code/highmaps.js') }}"></script>-->


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
					$('input[type=date]').datepicker();
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

		<!-- END JAVASCRIPT -->

	</body>
</html>
