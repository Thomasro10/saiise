<!DOCTYPE html>
<html lang="en">
	<head>
		<title>.:: Registro - SAIISE ::.</title>

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
		</section>

		<!-- BEGIN FORM MODAL MARKUP -->
		<div class="modal fade" id="modalReg" tabindex="-1" role="dialog" aria-labelledby="formModalLabel">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-body">
						<form class="form " id="addReg" accept-charset="utf-8"  >
							{{ csrf_field() }}
							<div class="card">
								<div class="card-head style-primary">
									<!--<div class="tools">
										<div class="btn-group">
											<a class="btn btn-icon-toggle" data-dismiss="modal" aria-hidden="true"><i class="md md-close"></i></a>
										</div>
									</div>-->
									<header>Registro</header>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<input type="text" class="form-control" id="empresa" name="empresa" required>
												<label for="empresa">Empresa</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<input type="text" class="form-control" id="rif" name="rif" required data-inputmask="'mask': 'R-99999999-9'">
												<label for="rif">RIF</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<select id="clasificacion" name="clasificacion" class="form-control" required>
													<option value="">&nbsp;</option>
                                                    <option value="MICRO">MICRO</option>
													<option value="PEQUENA">PEQUENA</option>
													<option value="MEDIANA">MEDIANA</option>
													<option value="GRANDE">GRANDE</option>

												</select>
												<label for="clasificacion">Clasificación</label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<select id="edo" name="edo" class="form-control" required onchange="getMcpiosPquias('edo','mcpio','{!! route('sistema.mcpios') !!}','pquia')">
													<option value="">&nbsp;</option>
													@foreach ($edos as $edo)
														<option value="{{ $edo->id }}">{{ $edo->nombre }}</option>
													@endforeach
												</select>
												<label for="edo1">Estado</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<select id="mcpio" name="mcpio" class="form-control" required onchange="getMcpiosPquias('mcpio','pquia','{!! route('sistema.pquias') !!}')">
													<option value="">&nbsp;</option>
												</select>
												<label for="mcpio1">Municipio</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<select id="pquia" name="pquia" class="form-control" required>
													<option value="">&nbsp;</option>
												</select>
												<label for="pquia1">Parroquia</label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<textarea name="direccion" id="direccion" class="form-control" rows="2" placeholder="" required></textarea>
												<label for="direccion">Dirección</label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<input type="text" class="form-control" id="contacto" name="contacto" placeholder="Se recomienda que sea el director o presidente" required>
												<label for="contacto">Nombre y apellido del contacto</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<input type="number" class="form-control" id="ci_cont" name="ci_cont" required>
												<label for="ci_cont">Cédula</label>
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group">
												<input type="text" class="form-control" id="cargo_cont" name="cargo_cont" required>
												<label for="cargo_cont">Cargo que ocupa en la empresa</label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<input type="text" class="form-control" id="telf" name="telf" required data-inputmask="'mask': '9999-9999999'">
												<label for="telf">Teléfono de contacto</label>
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group">
												<input type="email" class="form-control" id="email" name="email" required>
												<label for="email">Correo electrónico</label>
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group">
												{!! app('captcha')->display() !!}
											</div>
										</div>
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-default" onclick="location.href='{!! route('sistema.acceso') !!}'">Volver</button>
									<button type="button" class="btn btn-primary" id="btnAddReg">Registrarse</button>
									<!--<input type="submit" class="btn btn-primary" value="Guardar">-->
								</div>
							</div><!--end .card -->
						</form>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- END FORM MODAL MARKUP -->
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
					$.extend($.inputmask.defaults.definitions, {
						'R': {  //masksymbol
							"validator": "[vVeEjJgG]",
							"cardinality": 1,
							'prevalidator': null
						}
					});

					function getMcpiosPquias(el1, el2, urls, el3){
						if($('#'+el1).val()!=''){
							$.ajax({
								dataType: "json",
								url: urls,
								data: { edo: $('#'+el1).val(), mcpio : $('#'+el1).val(), rand: Math.random() },
								beforeSend: function() { $('#'+el2).addClass('ui-autocomplete-loading'); },
								success: function(data) {
									$('#'+el2).find('option:not(:first)').remove().removeClass('ui-autocomplete-loading');
									$.each(data, function(i, item) {
										$('#'+el2).append($('<option>').text(item.label).attr('value', item.value));
									});
								},
								complete:function(){ $('#'+el2).removeClass('ui-autocomplete-loading'); }
							});
						}
						else{
							if(el3){
								$('#'+el2+',#'+el3).find('option:not(:first)').remove();
							}
							else{
								$('#'+el2).find('option:not(:first)').remove();
							}

						}
					}

					$(function () {

						$(":input").inputmask();
						var fAddReg = $("#addReg");
						fAddReg.validate({
							ignore: ".ignore",
							rules: {
								"g-recaptcha-response": {
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
						$('#btnAddReg').click(function(){
							if(fAddReg.valid()){
								swal({
									title: "¿Esta seguro que quiere continuar con el registro?",
									text: "Esta acción no puede ser desecha",
									type: "warning",
									cancelButtonText: "No",
									showCancelButton: true,
									confirmButtonText: "Si, estoy seguro",
									reverseButtons: true
								}).then(function (text) {
									$.ajax({
										type: "POST",
										url:'{!! route('sistema.registro.add') !!}',
										data: fAddReg.serialize(),
										success: function( data ) {
											if(data.status == 1){
												swal(data.msg, "", "success");
												fAddReg.clearForm();
												grecaptcha.reset();
											}
											else{
												swal(data.msg, "", "error");
											}
										}
									});

								});
							}
						})
						$('#modalReg').modal({backdrop: 'static', keyboard: false},'show');
					})

	            </script>

			</body>
		</html>
