import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const echo = new Echo({
    broadcaster: 'reverb',
    key: process.env.MIX_REVERB_APP_KEY,
    cluster: process.env.MIX_REVERB_APP_CLUSTER,
    wsHost: process.env.MIX_REVERB_URL,
    wsPort: process.env.MIX_REVERB_PORT,
    wssPort: process.env.MIX_REVERB_PORT,
    forceTLS: (process.env.MIX_REVERB_SCHEME ?? 'https') === 'https',
    path: process.env.MIX_REVERB_PATH,
    enabledTransports: ['ws', 'wss'],
});

echo.channel('chat')
    .listen('.nuevo-mensaje', (e) => {
        console.log('Evento recibido:', e.mensaje);
    });

export default echo;


