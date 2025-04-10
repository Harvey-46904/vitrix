<div wire:poll.5s="cargarDatos"> 
   
    <p class="text-sm text-gray-500 text-light">Última actualización: {{ now()->format('H:i:s') }}</p>
    <div class="position-relative d-inline-block">
        <h2 class="text-xl font-bold mb-2 text-light {{ $animarBote ? 'bote-animado' : '' }}" wire:key="bote-{{ $bote }}">
            Bote Acumulado: ${{ number_format($bote, 2) }}
        </h2>
    
        @if ($animarBote && $boteDiferencia > 0)
            <div class="bote-flotante position-absolute text-success font-weight-bold">
                +${{ number_format($boteDiferencia, 2) }}
            </div>
        @endif
    </div>

    <h3 class="text-lg font-semibold mb-1">Top 5</h3>
    <ul>
        @foreach($lista as $nave)
            <li>
                {{ $nave->user->name ?? 'Sin usuario' }} - {{ $nave->puntuacion }} pts
            </li>
        @endforeach
    </ul>
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