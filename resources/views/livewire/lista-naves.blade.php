<div wire:poll.5s="cargarDatos">
    <h2 class="text-xl font-bold mb-2">Bote Acumulado: ${{ number_format($bote, 2) }}</h2>

    <h3 class="text-lg font-semibold mb-1">Top 5</h3>
    <ul>
        @foreach($lista as $nave)
            <li>
                {{ $nave->user->name ?? 'Sin usuario' }} - {{ $nave->puntuacion }} pts
            </li>
        @endforeach
    </ul>
</div>