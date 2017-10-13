<!DOCTYPE html>
<html lang="en">
	<head>
		<title>.:: Acceso - SAIISE ::.</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/bootstrap.css?1422792965') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/materialadmin.css?1425466319') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/font-awesome.min.css?1422529194') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/material-design-iconic-font.min.css?1421434286') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/js/libs/sweetalert/sweetalert2.css?1420463396') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/theme-1/libs/jquery-ui/jquery-ui-theme.css?1423393666') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::to('assets/css/loader_1.css?1423393666') }}" />
		<!-- END STYLESHEETS -->
		<style>
			.modal-xl {
				width: 90vw;
				max-width:1400px;
			}

			.ui-autocomplete-loading {
				background: url('{{ asset('assets/img/ui-anim_basic_16x16.gif') }}') no-repeat right center;
			}

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
		</style>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="{{ URL::to('assets/js/libs/utils/html5shiv.js?1403934957') }}"></script>
		<script type="text/javascript" src="{{ URL::to('assets/js/libs/utils/respond.min.js?1403934956') }}"></script>
		<![endif]-->
	</head>
	<body class="menubar-hoverable header-fixed ">
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




		<!-- BEGIN LOGIN SECTION -->
		<section class="section-account">
			<div class="img-backdrop" style="background-image: url('{!! asset('assets/img/img16.jpg') !!}')"></div>
			<div class="spacer"></div>
			<div class="card contain-sm style-transparent">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6">
							<br>
							<span class="text-lg text-bold text-primary">SAIISE</span><br>
                            <span class="text-xs text-primary">Sistema de Atención Integral a la Industria, Seguimiento y Evaluación</span>
							<br><br>
							<form class="form " id="acceso" accept-charset="utf-8" >
								{{ csrf_field() }}
								<div class="form-group">
									<input type="text" class="form-control" id="user" name="user" required>
									<label for="user">Usuario</label>
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="password" name="password" required>
									<label for="password">Clave</label>
									<!--<p class="help-block"><a href="#">Forgotten?</a></p>-->
								</div>
								<div class="form-group">
									{!! app('captcha')->display() !!}
								</div>
								<br/>
                                
								<div class="row">
									<!--<div class="col-xs-6 text-left">
										<div class="checkbox checkbox-inline checkbox-styled">
											<label>
												<input type="checkbox"> <span>Remember me</span>
											</label>
										</div>
									</div><!--end .col -->
									<div class="col-xs-12 text-right">
										<button class="btn ink-reaction btn-primary btn-raised" type="button" id="btnAcceso">Acceso</button>
									</div><!--end .col -->
								</div><!--end .row -->
							</form>
						</div><!--end .col -->

					<!--
						<div class="col-sm-5 col-sm-offset-1 text-center">
							<br><br>
							<h3 class="text-light">
								¿No tiene cuenta?
							</h3>

							<a class="btn ink-reaction btn-block btn-raised btn-primary" href="{{ route('sistema.registro') }}">Registrate aqui</a>
						</div>-->

							</div><!--end .row -->
						</div><!--end .card-body -->
					</div><!--end .card -->
				</section>


				<!-- END LOGIN SECTION -->

				<!-- BEGIN JAVASCRIPT -->
				<script src="{{ URL::to('assets/js/libs/jquery/jquery-1.11.2.min.js') }}"></script>
				<script src="{{ URL::to('assets/js/libs/jquery/jquery-migrate-1.2.1.min.js') }}"></script>
				<script src="{{ URL::to('assets/js/libs/bootstrap/bootstrap.min.js') }}"></script>
				<script src="{{ URL::to('assets/js/libs/spin.js/spin.min.js') }}"></script>
				<script src="{{ URL::to('assets/js/libs/autosize/jquery.autosize.min.js') }}"></script>
				<script src="{{ URL::to('assets/js/libs/nanoscroller/jquery.nanoscroller.min.js') }}"></script>

		        <script src="{{ URL::to('assets/js/libs/sweetalert/sweetalert2.min.js') }}"></script>
	          	<script src="{{ URL::to('assets/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
	        	<script src="{{ URL::to('assets/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
	        	<script src="{{ URL::to('assets/js/libs/jquery-validation/dist/localization/messages_es.js') }}"></script>
		        <script src="{{ URL::to('assets/js/libs/inputmask/jquery.inputmask.bundle.min.js') }}"></script>

				<script src="{{ URL::to('assets/js/core/source/App.js') }}"></script>
				<script src="{{ URL::to('assets/js/core/source/AppNavigation.js') }}"></script>
				<script src="{{ URL::to('assets/js/core/source/AppOffcanvas.js') }}"></script>
				<script src="{{ URL::to('assets/js/core/source/AppCard.js') }}"></script>
				<script src="{{ URL::to('assets/js/core/source/AppForm.js') }}"></script>
				<script src="{{ URL::to('assets/js/core/source/AppNavSearch.js') }}"></script>
				<script src="{{ URL::to('assets/js/core/source/AppVendor.js') }}"></script>
				<script src="{{ URL::to('assets/js/core/demo/Demo.js') }}"></script>
				<!-- END JAVASCRIPT -->
	            <script>
					$(document).ajaxStart(function() {
						$(".env-loader").show();
					}).ajaxStop(function() {
						$(".env-loader").hide();
					});

					$(function () {
						var acceso = $("#acceso");
						acceso.validate({
							ignore: ".ignore",
							rules: {
								'g-recaptcha-response': {
									required: function () {
										if (grecaptcha.getResponse() == '') {
											return true;
										} else {
											return false;
										}
									}
								}
							},
							messages: {
								"g-recaptcha-response": "Prueba que eres HUMANO"
							}
						});

						$('#btnAcceso').click(function(){
							if(acceso.valid()){
								$.ajax({
									type: "POST",
									url:'{!! route('sistema.validar') !!}',
									data: acceso.serialize(),
									success: function( data ) {
										if (data.status == 1) {
											location.href='{{ route('sistema.index') }}';
										}
										else {
											grecaptcha.reset();
											swal(data.msg, "", "error");
										}
									}
								});
							}
						})
					})

	            </script>

			</body>
		</html>
