@extends('theme::layouts.app')

@section('content')
<div class="container my-5 bg-gris neon-shadow py-3">
  <div class="row">
    <div class="col-md-12 text-center mb-4">
      <h1 class="display-4 gamers texturizado-warning">{{ __('general.info.recompensas.titulo1') }}</h1>
      <p class="lead">{{ __('general.info.recompensas.subtitulo1') }}</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <h2>{{ __('general.info.recompensas.titulo2') }}</h2>
      <p>{{ __('general.info.recompensas.descripcion1') }}</p>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-12">
      <h2>{{ __('general.info.recompensas.titulo3') }}</h2>
      <p>{{ __('general.info.recompensas.descripcion2') }}</p>
      <ul>
        <li><strong>🔸 {{ __('general.info.recompensas.nivel1') }}</strong></li>
        <li><strong>🔸 {{ __('general.info.recompensas.nivel2') }}</strong></li>
        <li><strong>🔸 {{ __('general.info.recompensas.nivel3') }}</strong></li>
        <li><strong>🔸 {{ __('general.info.recompensas.nivel4') }}</strong></li>
        <li><strong>🔸 {{ __('general.info.recompensas.nivel5') }}</strong></li>
      </ul>
      <p><strong>{{ __('general.info.recompensas.descripcion3_titulo') }}</strong> {{ __('general.info.recompensas.descripcion3_texto') }}</p>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-12">
      <h2>{{ __('general.info.recompensas.titulo4') }}</h2>
      <p>{{ __('general.info.recompensas.descripcion4') }}</p>
      <ul>
        <li><strong>🔹 {{ __('general.info.recompensas.juego1') }}</strong></li>
        <li><strong>🔹 {{ __('general.info.recompensas.juego2') }}</strong></li>
        <li><strong>🔹 {{ __('general.info.recompensas.juego3') }}</strong></li>
        <li><strong>🔹 {{ __('general.info.recompensas.juego4') }}</strong></li>
        <li><strong>🔹 {{ __('general.info.recompensas.juego5') }}</strong></li>
      </ul>
      <p><strong>{{ __('general.info.recompensas.descripcion5_titulo') }}</strong> {{ __('general.info.recompensas.descripcion5_texto') }}</p>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-12">
      <h2>{{ __('general.info.recompensas.titulo5') }}</h2>
      <ul>
        <li><strong>💰 {{ __('general.info.recompensas.final1') }}</strong></li>
        <li><strong>🌟 {{ __('general.info.recompensas.final2') }}</strong></li>
      </ul>
    </div>
  </div>
</div>
@endsection