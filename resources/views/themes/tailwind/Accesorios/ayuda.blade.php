@extends('theme::layouts.app')

@section('content')
<div class="container my-5 bg-gris neon-shadow py-3">
  <div class="row">
    <div class="col-md-12 text-center mb-4">
      <h1 class="display-4 gamers texturizado-warning">{{ __('general.info.ayuda.titulo1') }}</h1>
      <p class="lead">{{ __('general.info.ayuda.subtitulo1') }}</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <h2>{{ __('general.info.ayuda.titulo2') }}</h2>
      <p>{{ __('general.info.ayuda.descripcion1') }}</p>
      <p><strong>{{ __('general.info.ayuda.descripcion2') }}</strong></p>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-12">
      <h3>{{ __('general.info.ayuda.soporte_general_titulo') }}</h3>
      <p>{{ __('general.info.ayuda.soporte_general_descripcion') }}</p>
      <ul>
        <li>👉 <strong>Email:</strong> <a href="mailto:soporte@vitrix.io">soporte@vitrix.io</a></li>
      </ul>

      <h3>{{ __('general.info.ayuda.telegram_titulo') }}</h3>
      <p>{{ __('general.info.ayuda.telegram_descripcion') }}</p>
      <ul>
        <li>👉 <strong>Telegram:</strong> <a href="https://t.me/VitrixSoporte" target="_blank">@VitrixSoporte</a></li>
      </ul>
      <p>{{ __('general.info.ayuda.telegram_extra') }}</p>

      <h3>{{ __('general.info.ayuda.inversionistas_titulo') }}</h3>
      <p>{{ __('general.info.ayuda.inversionistas_descripcion') }}</p>
      <ul>
        <li>👉 <strong>Email:</strong> <a href="mailto:afiliados@vitrix.io">afiliados@vitrix.io</a></li>
        <li>👉 <strong>{{ __('general.info.ayuda.telegram_privado') }}</strong></li>
      </ul>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-12">
      <h3>{{ __('general.info.ayuda.consejo_titulo') }}</h3>
      <p>{{ __('general.info.ayuda.consejo_descripcion') }}</p>
    </div>
  </div>
</div>
@endsection