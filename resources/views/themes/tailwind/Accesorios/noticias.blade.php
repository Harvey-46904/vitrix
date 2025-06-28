@extends('theme::layouts.app')

@section('content')
<div class="container my-5 bg-gris neon-shadow py-3">
  <div class="row">
    <div class="col-md-12 text-center mb-4">
      <h1 class="display-4 gamers texturizado-warning">{{ __('general.info.news.titulo1') }}</h1>
      <p class="lead">{{ __('general.info.news.subtitulo1') }}</p>
      <p>{{ __('general.info.news.subtitulo2') }}</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <p>{{ __('general.info.news.descripcion1') }}</p>
      <ul>
        <li>{{ __('general.info.news.lista1') }}</li>
        <li>{{ __('general.info.news.lista2') }}</li>
        <li>{{ __('general.info.news.lista3') }}</li>
        <li>{{ __('general.info.news.lista4') }}</li>
      </ul>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-12">
      <p>{{ __('general.info.news.consejo') }}</p>
    </div>
  </div>
</div>
@endsection