<div wire:poll.5s="cargarDatos">
    <p class="text-sm text-gray-500 text-light">Última actualización: {{ now()->format('H:i:s') }}</p>
    <h2 class="text-xl font-bold mb-2 text-light">Bote Acumulado: ${{ number_format($bote, 2) }}</h2>

    <h3 class="text-lg font-semibold mb-1">Top 5</h3>
    <ul>
        @foreach($lista as $nave)
            <li>
                {{ $nave->user->name ?? 'Sin usuario' }} - {{ $nave->puntuacion }} pts
            </li>
        @endforeach
    </ul>
</div>