@extends('theme::layouts.app')

@section('content')
<div class="container my-5 bg-gris neon-shadow py-3">
  <div class="row">
    <div class="col-md-12 text-center mb-4">
      <h1 class="display-4 gamers texturizado-warning">{{ __('general.info.inversion_oportunidad.titulo1') }}</h1>
      <p class="lead">{{ __('general.info.inversion_oportunidad.descripcion1') }}</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <h2>{{ __('general.info.inversion_oportunidad.titulo2') }}</h2>
      <p>{{ __('general.info.inversion_oportunidad.descripcion2') }}</p>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-12">
      <h2>{{ __('general.info.inversion_oportunidad.titulo3') }}</h2>
      <p>{{ __('general.info.inversion_oportunidad.descripcion3') }}</p>
      <p>{{ __('general.info.inversion_oportunidad.descripcion4') }}</p>
      <ul>
        <li><strong>🔐 {{ __('general.info.inversion_oportunidad.pilar1_titulo') }}</strong> {{ __('general.info.inversion_oportunidad.pilar1_texto') }}</li>
        <li><strong>🌍 {{ __('general.info.inversion_oportunidad.pilar2_titulo') }}</strong> {{ __('general.info.inversion_oportunidad.pilar2_texto') }}</li>
        <li><strong>♻️ {{ __('general.info.inversion_oportunidad.pilar3_titulo') }}</strong> {{ __('general.info.inversion_oportunidad.pilar3_texto') }}</li>
      </ul>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-12">
      <h2>{{ __('general.info.inversion_oportunidad.titulo4') }}</h2>
      <p>{{ __('general.info.inversion_oportunidad.descripcion5') }}</p>
      <ul>
        <li><strong>📈 {{ __('general.info.inversion_oportunidad.beneficio1_titulo') }}</strong> {{ __('general.info.inversion_oportunidad.beneficio1_texto') }}</li>
        <li><strong>🤝 {{ __('general.info.inversion_oportunidad.beneficio2_titulo') }}</strong> {{ __('general.info.inversion_oportunidad.beneficio2_texto') }}</li>
      </ul>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-md-12">
      <h2>{{ __('general.info.inversion_oportunidad.titulo5') }}</h2>
      <p>{{ __('general.info.inversion_oportunidad.descripcion6') }}</p>
    </div>
  </div>
</div>
@endsection