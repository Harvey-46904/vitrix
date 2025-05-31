@extends('theme::layouts.app')

@section('content')
<div class="container my-5 bg-gris neon-shadow py-3">
  <div class="row">
    <div class="col-md-12 text-center mb-4">
      <h1 class="display-4 gamers texturizado-warning">📬 Contáctanos</h1>
      <p class="lead">Estamos aquí para ayudarte.</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <p>¿Tienes preguntas, sugerencias o necesitas asistencia personalizada? En <strong>Vitrix</strong>, valoramos tu experiencia y queremos escucharte. Nuestro equipo está disponible para responderte de forma rápida, clara y segura.</p>

      <h3 class="mt-4">🛠️ Canales de contacto disponibles</h3>
      <ul>
        <li><strong>📩 Correo de Soporte:</strong><br>
          👉 <a href="mailto:soporte@vitrix.io">soporte@vitrix.io</a><br>
          Para consultas generales, técnicas o sobre tu cuenta.
        </li>
        <li class="mt-3"><strong>📱 Canal de Telegram Oficial:</strong><br>
          👉 <a href="https://t.me/vitrixoficial" target="_blank">t.me/vitrixoficial</a><br>
          Únete para recibir anuncios, resolver dudas frecuentes y estar cerca de la comunidad.
        </li>
      </ul>

      <h4 class="mt-4">💡 ¿Problemas técnicos urgentes?</h4>
      <p>Especifica el error o adjunta una captura en tu mensaje. Nuestro equipo de soporte técnico prioriza estos casos para darte una solución rápida.</p>

      <div class="alert alert-success mt-4" role="alert">
        🤝 En Vitrix, cada jugador y cada inversor cuenta.<br>
        No estás solo, estás respaldado por un equipo que te acompaña en todo momento.
      </div>
    </div>
  </div>
</div>
@endsection
