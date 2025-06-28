@extends('theme::layouts.app')

@section('content')
<div class="container my-5 bg-gris neon-shadow py-3">
  <div class="row">
    <div class="col-md-12 text-center mb-4">
      <h1 class="display-4 gamers texturizado-warning">{{ __('general.info.faq.titulo') }}</h1>
      <p class="lead">{{ __('general.info.faq.subtitulo1') }}</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">

      <h3 class="mt-4">{{ __('general.info.faq.seccion1') }}</h3>
      <p><strong>{{ __('general.info.faq.p1_titulo') }}</strong><br>
      {{ __('general.info.faq.p1_texto') }}</p>

      <p><strong>{{ __('general.info.faq.p2_titulo') }}</strong><br>
      {{ __('general.info.faq.p2_texto') }}</p>

      <h3 class="mt-4">{{ __('general.info.faq.seccion2') }}</h3>
      <p><strong>{{ __('general.info.faq.p3_titulo') }}</strong><br>
      {{ __('general.info.faq.p3_texto') }}</p>

      <p><strong>{{ __('general.info.faq.p4_titulo') }}</strong><br>
      {{ __('general.info.faq.p4_texto') }}</p>

      <h3 class="mt-4">{{ __('general.info.faq.seccion3') }}</h3>
      <p><strong>{{ __('general.info.faq.p5_titulo') }}</strong><br>
      {{ __('general.info.faq.p5_texto') }}</p>

      <p><strong>{{ __('general.info.faq.p6_titulo') }}</strong><br>
      {{ __('general.info.faq.p6_texto') }}</p>

      <p><strong>{{ __('general.info.faq.p7_titulo') }}</strong><br>
      {{ __('general.info.faq.p7_texto') }}</p>

      <p><strong>{{ __('general.info.faq.p8_titulo') }}</strong><br>
      {{ __('general.info.faq.p8_texto') }}</p>

      <p><strong>{{ __('general.info.faq.p9_titulo') }}</strong><br>
      {{ __('general.info.faq.p9_texto') }}</p>

      <p><strong>{{ __('general.info.faq.p10_titulo') }}</strong><br>
      {{ __('general.info.faq.p10_texto') }}</p>

      <p><strong>{{ __('general.info.faq.p11_titulo') }}</strong><br>
      {{ __('general.info.faq.p11_texto') }}</p>

      <p><strong>{{ __('general.info.faq.p12_titulo') }}</strong><br>
      {{ __('general.info.faq.p12_texto') }}</p>

      <p><strong>{{ __('general.info.faq.p13_titulo') }}</strong><br>
      {{ __('general.info.faq.p13_texto') }}</p>

      <h3 class="mt-4">{{ __('general.info.faq.seccion4') }}</h3>
      <p>{{ __('general.info.faq.p14_texto') }}</p>

      <strong>{{ __('general.info.faq.p15_titulo') }}</strong>
      <ol>
        <li>{{ __('general.info.faq.p15_paso1') }}</li>
        <li>{{ __('general.info.faq.p15_paso2') }}</li>
        <li>{{ __('general.info.faq.p15_paso3') }}</li>
        <li>{{ __('general.info.faq.p15_paso4') }}</li>
        <li>{{ __('general.info.faq.p15_paso5') }}</li>
      </ol>

      <p><strong>{{ __('general.info.faq.p16_titulo') }}</strong><br>
      {{ __('general.info.faq.p16_texto') }}</p>

    </div>
  </div>
</div>
@endsection