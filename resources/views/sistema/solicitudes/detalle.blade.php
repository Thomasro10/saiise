@foreach($solicitud as $e)
 <div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-head card-head-xs style-primary-bright">
        <header>Información base</header>
      </div><!--end .card-head -->
      <div class="card-body">

          <div class="row">
            <div class="col-sm-3">ID: <b>{{ $e->id }}</b></div>
            <div class="col-sm-3">Fecha de registro: <b>{{ $e->fecha  }}</b></div>
            <div class="col-sm-6">Empresa: <b>{{ $e->empresa  }}</b></div>
          </div>
          <div class="row">
            <div class="col-sm-12">Origen de la solicitud: <b>{{ $e->origen  }}</b></div>
          </div>
          <div class="row">
              <div class="col-sm-12">Si es Viceministros, ferias o exposiciones u otros: <b>{{ $e->ori_especifique  }}</b></div>
          </div>
          <div class="row">
              <div class="col-sm-12">Objeto de la solicitud: <b>{{ $e->objeto  }}</b></div>
          </div>
          <div class="row">
              <div class="col-sm-12">Observación: <b>{{ $e->observacion  }}</b></div>
          </div>

      </div><!--end .card-body -->
    </div><!--end .card -->
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-head card-head-xs style-primary-bright">
        <header>Si el objeto de la solicitud es <b>PRESENTACIÓN DE PROYECTO</b></header>
      </div><!--end .card-head -->
      <div class="card-body">
              <div class="row">
                  <div class="col-sm-12">Descripción del proyecto:  <b>{{ $e->obj_proyecto }}</b></div>
              </div>
      </div><!--end .card-body -->
    </div><!--end .card -->
  </div>
</div>

 <div class="row">
     <div class="col-sm-12">
         <div class="card">
             <div class="card-head card-head-xs style-primary-bright">
                 <header>Si el objeto de la solicitud es <b>FINANCIAMIENTO</b></header>
             </div><!--end .card-head -->
             <div class="card-body">
                     <div class="row">
                         <div class="col-sm-4">Monto en Bs: <b>{{ number_format($e->fin_montobs, 0, ',', '.')  }}</b></div>
                         <div class="col-sm-4">Monto en USD: <b>{{ number_format($e->fin_montousd, 0, ',', '.')  }}</b></div>
                         <div class="col-sm-4">Para: <b>{{ $e->fin_para  }}</b></div>
                     </div>
             </div><!--end .card-body -->
         </div><!--end .card -->
     </div>
 </div>

 <div class="row">
     <div class="col-sm-12">
         <div class="card">
             <div class="card-head card-head-xs style-primary-bright">
                 <header>Si el objeto de la solicitud es <b>OTROS</b></header>
             </div><!--end .card-head -->
             <div class="card-body">
                 <div class="row">
                     <div class="col-sm-12">Descripción: <b>{{ $e->sol_otros  }}</b></div>
                 </div>
             </div><!--end .card-body -->
         </div><!--end .card -->
     </div>
 </div>
@endforeach

@if($e->objeto == 'MATERIA PRIMA')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-head card-head-xs style-primary-bright">
                <header>Si el objeto de la solicitud es <b>MATERIA PRIMA</b></header>
            </div><!--end .card-head -->
            <div class="card-body">
                @foreach($mprima as $e)
                    <div class="row">
                        <div class="col-sm-3">Tipo: <b>{{ $e->tipo  }}</b></div>
                        <div class="col-sm-3">Descripción: <b>{{ $e->descripcion  }}</b></div>
                        <div class="col-sm-3">Cantidad: <b>{{ number_format($e->cantidad, 0, ',', '.')  }}</b></div>
                        <div class="col-sm-3">Medida: <b>{{ $e->medida  }}</b></div>
                    </div>
                @endforeach
            </div><!--end .card-body -->
        </div><!--end .card -->
    </div>
</div>
@endif
@if($e->objeto == 'PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-head card-head-xs style-primary-bright">
                <header>Si el objeto de la solicitud es <b>PERMISOLOGIA, LICENCIAS, CERTIFICADOS U TRAMITES VARIOS</b></header>
            </div><!--end .card-head -->
            <div class="card-body">
                @foreach($permisos as $e)
                    <div class="row">
                        <div class="col-sm-6">Institución: <b>{{ $e->institucion  }}</b></div>
                        <div class="col-sm-6">Descripción: <b>{{ $e->descripcion  }}</b></div>
                    </div>
                @endforeach
            </div><!--end .card-body -->
        </div><!--end .card -->
    </div>
</div>
@endif



