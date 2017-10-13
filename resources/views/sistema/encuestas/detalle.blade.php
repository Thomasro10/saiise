<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-head card-head-xs style-primary-bright">
        <header>Información base</header>
      </div><!--end .card-head -->
      <div class="card-body">
        @foreach($encuestas as $e)
          <div class="row">
            <div class="col-sm-4">Fecha de registro: <b>{{ $e->fecha  }}</b></div>
            <div class="col-sm-4">Empresa: <b>{{ $e->empresa  }}</b></div>
            <div class="col-sm-4">RIF: <b>{{ $e->rif  }}</b></div>
          </div>
          <div class="row">
            <div class="col-sm-3">Tipo de empresa: <b>{{ $e->tempresa  }}</b></div>
            <div class="col-sm-3">Nº de trabajadores: <b>{{ $e->ntrabajadores  }}</b></div>
            <div class="col-sm-3">Actividad económica: <b>{{ $e->acteconomica  }}</b></div>
            <div class="col-sm-3">Si es otra, especifique: <b>{{ $e->aeespec  }}</b></div>
          </div>
          <div class="row">
            <div class="col-sm-6">Capacidad Instalada: <b>{{ number_format($e->capinstalada, 0, ',', '.')  }}</b></div>
            <div class="col-sm-6">Unidad de medida: <b>{{ $e->medida  }}</b></div>
          </div>
          <div class="row">
            <div class="col-sm-2">Prod. 2013: <b>{{ number_format($e->pdc2013, 0, ',', '.')  }}</b></div>
            <div class="col-sm-2">Prod. 2014: <b>{{ number_format($e->pdc2014, 0, ',', '.')  }}</b></div>
            <div class="col-sm-2">Prod. 2015: <b>{{ number_format($e->pdc2015, 0, ',', '.')  }}</b></div>
            <div class="col-sm-2">Prod. 2016: <b>{{ number_format($e->pdc2016, 0, ',', '.')  }}</b></div>
            <div class="col-sm-2">Prod. Actual: <b>{{ number_format($e->pdcactual, 0, ',', '.')  }}</b></div>
            <div class="col-sm-2">Cap. Operativa: <b>{{ $e->capoperativa  }}</b></div>
          </div>
          <div class="row">
            <div class="col-sm-3">Motor: <b>{{ $e->motor  }}</b></div>
            <div class="col-sm-3">Si es otro, especifique: <b>{{ $e->motorespc  }}</b></div>
            <div class="col-sm-3">Materia Prima: <b>{{ $e->mprima  }}</b></div>
            <div class="col-sm-3">Descripción: <b>{{ $e->descripcion  }}</b></div>
          </div>
          <div class="row">
            <div class="col-sm-6">Mercado a abastecer: <b>{{ $e->mercabast  }}</b></div>
            <div class="col-sm-6">Principal rubro: <b>{{ $e->rubros  }}</b></div>
          </div>
          <div class="row">
            <div class="col-sm-12">Obstaculos: <b>{{ $e->obstaculos  }}</b></div>
          </div>
        @endforeach
      </div><!--end .card-body -->
    </div><!--end .card -->
  </div>
</div>
