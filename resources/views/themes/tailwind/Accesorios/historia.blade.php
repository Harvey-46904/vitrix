@extends('theme::layouts.app')

@section('content')
<div class="container my-5 bg-gris neon-shadow py-3">
  <div class="row">
    <div class="col-md-12 text-center mb-4">
      <h1 class="display-4 gamers texturizado-warning">{{ __('general.info.historia.titulo1') }}</h1>
      <p class="lead">{{ __('general.info.historia.subtitulo1') }}</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <h2>{{ __('general.info.historia.titulo2') }}</h2>
      <p>{{ __('general.info.historia.descripcion1') }}</p>
      <p><strong>{{ __('general.info.historia.descripcion2') }}</strong></p>
      <p>{{ __('general.info.historia.descripcion3') }}</p>
      <ul>
        <li>{{ __('general.info.historia.lista1') }}</li>
        <li>{{ __('general.info.historia.lista2') }}</li>
        <li>{{ __('general.info.historia.lista3') }}</li>
      </ul>
      <p><strong>{{ __('general.info.historia.descripcion4') }}</strong></p>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-12">
      <h2>{{ __('general.info.historia.titulo3') }}</h2>
      <p><strong>{{ __('general.info.historia.descripcion5') }}</strong></p>
      <ul>
        <li>{{ __('general.info.historia.lista4') }}</li>
        <li>{{ __('general.info.historia.lista5') }}</li>
      </ul>
      <p>{{ __('general.info.historia.descripcion6') }}</p>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-12">
      <h2>{{ __('general.info.historia.titulo4') }}</h2>
      <p>{{ __('general.info.historia.descripcion7') }}</p>
      <p><strong>{{ __('general.info.historia.descripcion8') }}</strong></p>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-12 text-center">
      <h3>{{ __('general.info.historia.titulo5') }}</h3>
      <p class="lead">{{ __('general.info.historia.subtitulo2') }}</p>
      <ul class="list-unstyled">
        <li>{{ __('general.info.historia.accion1') }}</li>
        <li>{{ __('general.info.historia.accion2') }}</li>
        <li>{{ __('general.info.historia.accion3') }}</li>
      </ul>
    </div>
  </div>
</div>
@endsection