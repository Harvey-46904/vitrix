@extends('theme::layouts.app')

@section('content')
<div class="container my-5 bg-gris neon-shadow py-3">
  <div class="row">
    <div class="col-md-12 text-center mb-4">
      <h1 class="display-4 gamers texturizado-danger">☠️ Cuenta Cancelada</h1>
      <p class="lead">Lamentamos informarte que tu acceso ha sido revocado.</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <p class="text-justify">
        Tu cuenta ha sido <strong>cancelada permanentemente</strong> debido a una o más de las siguientes razones:
      </p>
      <ul class="text-danger">
        <li>💀 Violación a los <a href="#">Términos y Condiciones</a> de Vitrix</li>
        <li>💀 Indicios de trampas o manipulación del sistema</li>
        <li>💀 Actividades inusuales que comprometen la seguridad de la plataforma</li>
        <li>💀 Uso indebido de bonificaciones o recompensas</li>
        <li>💀 Comportamiento fraudulento u ofensivo dentro de la comunidad</li>
      </ul>
      <p class="text-justify mt-4">
        Entendemos que en ocasiones pueden presentarse errores. Si consideras que esta decisión fue injusta o deseas más información, puedes comunicarte con nuestro equipo de soporte para resolver el caso.
      </p>

      <div class="text-center mt-5">
        <a href="https://t.me/vitrixsupport" target="_blank" class="btn btn-danger btn-lg mx-2">
          📩 Contactar Soporte
        </a>
        <a href="mailto:soporte@vitrix.io" class="btn btn-warning btn-lg mx-2">
          📨 Enviar un Correo
        </a>
      </div>
    </div>
  </div>
</div>
@endsection