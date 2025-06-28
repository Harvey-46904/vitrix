<div>
   <div id="contenedor-principal" class="container" wire:init="marcarListo" @if($pollDelay) wire:poll.{{ $pollDelay }} @endif>

        @if($sala && $ultimo)

        @if ($sala->point4 !=null)
        <div class="row  justify-content-center align-items-center my-5" style="min-height: 50vh;">
            <div class="col-md-12 text-center">
                <div class="p-4 rounded shadow-lg  bg-opacity-75">
                    <h1 class="display-3 text-warning fw-bold bg-primary py-2">
                        🏁 ¡Carrera finalizada! 🏆
                    </h1>
                    <h2 class="text-warning mt-3  bg-primary">
                        El ganador es <span class="text-dark">{{ $ultimo['jugador'] }}</span> 
                       <div id="gif-final" data-imagenes='@json($ultimo['imagenes'])'>
    <img id="imagen-animada" src="{{ asset('storage/' . $ultimo['imagenes'][0] ?? '') }}" class="img-fluid"> 🎉
</div>
                    </h2>
                   <script>
    document.addEventListener('DOMContentLoaded', () => {
        const contenedor = document.getElementById('gif-final');
        const imagenesRutas = JSON.parse(contenedor.dataset.imagenes || '[]');
        const img = document.getElementById('imagen-animada');

        let imagenesPrecargadas = [];
        let index = 0;

        if (imagenesRutas.length && img) {
            // Precargar imágenes en memoria
            imagenesRutas.forEach(ruta => {
                const imagen = new Image();
                imagen.src = `/storage/${ruta}`;
                imagenesPrecargadas.push(imagen);
            });

            // Mostrar la secuencia desde las imágenes precargadas
            setInterval(() => {
                img.src = imagenesPrecargadas[index].src;
                index = (index + 1) % imagenesPrecargadas.length;
            }, 300);
        }
    });
</script>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-md-7">
                <div id="gif-simulacion">
                    <img id="imagen-animada" src="{{ asset('storage/' . $ultimo['imagenes'][0] ?? '') }}"
                        class="img-thumbnail">
                </div>
            </div>

            <div class="col-md-5">
                <div id="narrador-contenido" data-jugador="{{ $ultimo['jugador'] }}"
                    data-numero="{{ $ultimo['numero'] }}" data-imagenes='@json($ultimo['imagenes'] ?? [])'
                    class="burbuja-dialogo text-dark p-3">
                    <!-- texto generado dinámicamente -->
                </div>
                <img src="{{ asset('wave/img/narrador.png') }}" alt="Narrador" class="img-fluid narrador-animado">
            </div>
        </div>

        @endif


       
        @else
        <div class="row">
            <div class="col-md-7">
                <div id="narrador-texto-bienvenida" class="burbuja-dialogo text-dark p-3" wire:ignore>
                   <span style="visibility: hidden;">🚦¡La carrera está por comenzar! Afinen motores, ajusten cinturones y prepárense para darlo TODO en la pista 🏁🔥</span>
                </div>
            </div>
            <div class="col-md-5">
                <img src="{{ asset('wave/img/narrador.png') }}" alt="Narrador" class="img-fluid narrador-animado">
            </div>
        </div>
        @endif
    </div>

    <!-- Scripts -->
    <script>
        let gifImagenes = [];
    let gifIndex = 0;
    let gifIntervalo = null;
    let anteriorJugador = null;
    let anteriorNumero = null;
    let textoActual = '';
    let typingInterval;

    function iniciarGif() {
        console.log("iniciando");
        
        if (gifIntervalo) clearInterval(gifIntervalo);
        if (!gifImagenes.length) return;

        gifIntervalo = setInterval(() => {
            const img = document.getElementById('imagen-animada');
            if (img) {
                img.src = `/storage/${gifImagenes[gifIndex]}`;
                gifIndex = (gifIndex + 1) % gifImagenes.length;
            }
        }, 300);
    }

    function escribirTexto(frase, destinoId) {
        if (textoActual === frase) return;
        clearInterval(typingInterval);
        textoActual = frase;

        const destino = document.getElementById(destinoId);
        if (!destino) return;

        destino.textContent = "";
        let i = 0;
        typingInterval = setInterval(() => {
            if (i < frase.length) {
                destino.textContent += frase[i];
                i++;
            } else {
                clearInterval(typingInterval);
            }
        }, 40);
    }

    function narrarEvento(jugador) {
        const frases = [
            `¡${jugador} toma la delantera con fuerza!`,
            `¡${jugador} acelera como nunca antes!`,
            `¡Atención! ${jugador} cambia todo el panorama.`,
            `${jugador} podría llevarse la victoria...`
        ];
        const frase = frases[Math.floor(Math.random() * frases.length)];
        escribirTexto(frase, 'narrador-contenido');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const bienvenida = document.getElementById('narrador-texto-bienvenida');
        if (bienvenida) {
            escribirTexto("🚦¡La carrera está por comenzar! Afinen motores, ajusten cinturones y prepárense para darlo TODO en la pista 🏁🔥", 'narrador-texto-bienvenida');
        }
    });
  
    document.addEventListener('livewire:load', () => {
        Livewire.hook('message.processed', () => {
            console.log("hoola",i++);
            
             const contenedor = document.getElementById('contenedor-principal');
             if (contenedor && contenedor.hasAttribute('wire:poll.2s')) {
            contenedor.removeAttribute('wire:poll.2s');
            contenedor.setAttribute('wire:poll.8s', '');
        }
            const el = document.getElementById('narrador-contenido');
            if (!el) return;

            const jugador = el.dataset.jugador;
            const numero = el.dataset.numero;
            const nuevas = JSON.parse(el.dataset.imagenes || "[]");

            if (jugador !== anteriorJugador || numero !== anteriorNumero) {
                anteriorJugador = jugador;
                anteriorNumero = numero;

                narrarEvento(jugador);

                gifImagenes = nuevas;
                gifIndex = 0;
                iniciarGif();
            }
        });
    });
    </script>
</div>