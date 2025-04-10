
<div wire:poll.5s="cargarDatos"> 
   
   
    <p class="text-sm text-gray-500 text-light">Última actualización: {{ now()->format('H:i:s') }}</p>
    <div class="position-relative d-inline-block">
        <h2 class="text-xl font-bold mb-2 text-light {{ $animarBote ? 'bote-animado' : '' }}" wire:key="bote-{{ $bote }}">
            <b class="text-warning"> Acumulado: $</b>{{ number_format($bote, 2) }}
        </h2>
    
        @if ($animarBote && $boteDiferencia > 0)
            <div class="bote-flotante position-absolute text-success font-weight-bold">
                +${{ number_format($boteDiferencia, 2) }}
            </div>
        @endif
    </div>

    <h3 class="text-lg font-semibold mb-1">Top 5</h3>
    <div class="podio text-center my-4">
        @php
            $top3 = $lista->take(3);
            $resto = $lista->slice(3);
        @endphp
    
        <div class="row justify-content-center align-items-end mb-4">
            {{-- Segundo lugar --}}
            @if(isset($top3[1]))
            <div class="col-4">
                <div class="bg-secondary text-white p-2 rounded">
                    🥈<br>
                    {{ $top3[1]->user->name ?? 'Sin usuario' }}<br>
                    {{ $top3[1]->puntuacion }} pts
                </div>
            </div>
            @endif
    
            {{-- Primer lugar --}}
            @if(isset($top3[0]))
            <div class="col-4">
                <div class="bg-warning text-dark p-3 rounded" style="font-size: 1.2rem;">
                    🥇<br>
                    {{ $top3[0]->user->name ?? 'Sin usuario' }}<br>
                    {{ $top3[0]->puntuacion }} pts
                </div>
            </div>
            @endif
    
            {{-- Tercer lugar --}}
            @if(isset($top3[2]))
            <div class="col-4">
                <div class="bg-info text-white p-2 rounded">
                    🥉<br>
                    {{ $top3[2]->user->name ?? 'Sin usuario' }}<br>
                    {{ $top3[2]->puntuacion }} pts
                </div>
            </div>
            @endif
        </div>
    
        {{-- Resto de jugadores --}}
        <ul class="list-group list-group-flush">
            @foreach($resto as $nave)
                <li class="list-group-item bg-dark text-light">
                    {{ $nave->user->name ?? 'Sin usuario' }} - {{ $nave->puntuacion }} pts
                </li>
            @endforeach
        </ul>
    </div>
</div>

@push('scripts')
<script>
    window.addEventListener('resetAnimacionBote', () => {
        setTimeout(() => {
            @this.set('boteDiferencia', 0);
        }, 1000); // igual al tiempo de la animación
    });
</script>
@endpush