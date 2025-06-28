@extends('theme::layouts.app')

@section('content')
<div class="container my-5 bg-gris neon-shadow py-3">
  <div class="row">
    <div class="col-md-12 text-center mb-4">
      <h1 class="display-4 gamers texturizado-danger">{{ __('general.info.terminos.titulo') }}</h1>
      <p class="lead">{{ __('general.info.terminos.subtitulo') }}</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <p class="text-justify">
        {{ __('general.info.terminos.descripcion') }}
      </p>
    </div>
  </div>
</div>
@endsection