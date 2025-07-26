import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
/*
const echo = new Echo({
  broadcaster: 'reverb',
  key: process.env.MIX_REVERB_APP_KEY,
  wsHost: process.env.MIX_REVERB_URL,   // `vitrix.io`
  wsPort: process.env.MIX_REVERB_PORT,  // `6001` *siempre en HTTPS via proxy en 443*
  wssPort: process.env.MIX_REVERB_PORT,
  forceTLS: (process.env.MIX_REVERB_SCHEME ?? 'https') === 'https',
  path: process.env.MIX_REVERB_PATH,     // `/app`
  enabledTransports: ['ws', 'wss'],
});*/

const echo = new Echo({
    broadcaster: 'reverb',
    key: 'yqm2nb6artaghbaqs7mx',
    wsHost: 'vitrix.io',
    wsPort: 443,
    wssPort: 443,
    forceTLS: true,
    enabledTransports: ['ws', 'wss'],
    path: '/reverb',
});

echo.channel('chat')
    .listen('.nuevo-mensaje', (e) => {
        console.log('Evento recibido:', e.mensaje);
    });

export default echo;


