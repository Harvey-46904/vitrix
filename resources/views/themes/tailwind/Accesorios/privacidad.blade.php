@extends('theme::layouts.app')

@section('content')
<div class="container my-5 bg-gris neon-shadow py-3">
  <div class="row">
    <div class="col-md-12 text-center mb-4">
      <h1 class="display-4 gamers texturizado-warning">{{ __('general.info.privacidad.titulo') }}</h1>
      <p class="lead">{{ __('general.info.privacidad.subtitulo') }}</p>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-12">
      <p>{{ __('general.info.privacidad.descripcion1') }}</p>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-12">
      <h2>{{ __('general.info.privacidad.titulo2') }}</h2>
      <ul>
        <li>• {{ __('general.info.privacidad.item1') }}</li>
        <li>• {{ __('general.info.privacidad.item2') }}</li>
        <li>• {{ __('general.info.privacidad.item3') }}</li>
        <li>• {{ __('general.info.privacidad.item4') }}</li>
        <li>• {{ __('general.info.privacidad.item5') }}</li>
      </ul>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-12">
      <h2>{{ __('general.info.privacidad.titulo3') }}</h2>
      <ul>
        <li>• {{ __('general.info.privacidad.item6') }}</li>
        <li>• {{ __('general.info.privacidad.item7') }}</li>
        <li>• {{ __('general.info.privacidad.item8') }}</li>
        <li>• {{ __('general.info.privacidad.item9') }}</li>
        <li>• {{ __('general.info.privacidad.item10') }}</li>
        <li>• {{ __('general.info.privacidad.item11') }}</li>
      </ul>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-12">
      <p>{{ __('general.info.privacidad.descripcion2') }}</p>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-12">
      <h2>{{ __('general.info.privacidad.titulo4') }}</h2>
      <ul>
        <li>• {{ __('general.info.privacidad.item12') }}</li>
        <li>• {{ __('general.info.privacidad.item13') }}</li>
        <li>• {{ __('general.info.privacidad.item14') }}</li>
        <li>• {{ __('general.info.privacidad.item15') }}</li>
      </ul>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-12">
      <p>{{ __('general.info.privacidad.descripcion3') }}</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <p>{{ __('general.info.privacidad.descripcion4') }}</p>
    </div>
  </div>
</div>
@endsection