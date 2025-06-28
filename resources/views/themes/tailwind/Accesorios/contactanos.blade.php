@extends('theme::layouts.app')

@section('content')
<div class="container my-5 bg-gris neon-shadow py-3">
  <div class="row">
    <div class="col-md-12 text-center mb-4">
      <h1 class="display-4 gamers texturizado-warning">{{ __('general.info.contacto.titulo') }}</h1>
      <p class="lead">{{ __('general.info.contacto.subtitulo') }}</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <p>{{ __('general.info.contacto.descripcion') }}</p>

      <h3 class="mt-4">{{ __('general.info.contacto.canales') }}</h3>
      <ul>
        <li><strong>{{ __('general.info.contacto.correo_titulo') }}</strong><br>
          👉 <a href="mailto:soporte@vitrix.io">soporte@vitrix.io</a><br>
          {{ __('general.info.contacto.correo_texto') }}
        </li>
        <li class="mt-3"><strong>{{ __('general.info.contacto.telegram_titulo') }}</strong><br>
          👉 <a href="https://t.me/vitrixoficial" target="_blank">t.me/vitrixoficial</a><br>
          {{ __('general.info.contacto.telegram_texto') }}
        </li>
      </ul>

      <h4 class="mt-4">{{ __('general.info.contacto.tecnico_titulo') }}</h4>
      <p>{{ __('general.info.contacto.tecnico_texto') }}</p>

      <div class="alert alert-success mt-4" role="alert">
        {{ __('general.info.contacto.alerta') }}
      </div>
    </div>
  </div>
</div>
@endsection