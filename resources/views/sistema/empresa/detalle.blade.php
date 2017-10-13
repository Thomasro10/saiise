
        @foreach($encuestas as $e)
          <div class="row">
              <!--<div class="col-sm-2">Nº: <b>{{ $e->id  }}</b></div>-->
              <div class="col-sm-4">Empresa: <b>{{ $e->empresa  }}</b></div>
              <div class="col-sm-4">RIF: <b>{{ $e->rif  }}</b></div>
              <div class="col-sm-4">Clasificación: <b>{{ $e->clasificacion  }}</b></div>
          </div>
          <div class="row">
          <!--<div class="col-sm-2">Nº: <b>{{ $e->id  }}</b></div>-->
              <div class="col-sm-4">Gran sector: <b>{{ $e->sector  }}</b></div>
              <div class="col-sm-4">Rubro principal: <b>{{ $e->rubro  }}</b></div>
              <div class="col-sm-4">Convenio (firma): <b>{{ $e->convenio  }}</b></div>
          </div>
          <div class="row">
              <div class="col-sm-4">Estado: <b>{{ $e->estado  }}</b></div>
              <div class="col-sm-4">Municipio: <b>{{ $e->municipio  }}</b></div>
              <div class="col-sm-4">Parroquia: <b>{{ $e->parroquia  }}</b></div>
          </div>
          <div class="row">
              <div class="col-sm-12">Dirección: <b>{{ $e->direccion  }}</b></div>
          </div>

          <div class="row">
            <div class="col-sm-4">Contacto: <b>{{ $e->contacto  }}</b></div>
            <div class="col-sm-4">CI: <b>{{ number_format($e->ci_cont, 0, ',', '.')  }}</b></div>
            <div class="col-sm-4">Cargo: <b>{{ $e->cargo_cont  }}</b></div>
          </div>
          <div class="row">
           <div class="col-sm-6">Telf.: <b>{{ $e->telf  }}</b></div>
           <div class="col-sm-6">Email: <b>{{ $e->email  }}</b></div>
          </div>
        @endforeach
