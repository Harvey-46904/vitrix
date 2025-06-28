<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sala;

class SalaLive extends Component
{
    public $salaId;
    public $sala;
    public $listo = false;
    public $pollDelay = '2s';
    public $ganador=false;
    protected $listeners = ['refreshSala' => '$refresh'];


    public function marcarListo()
{
    $this->listo = true;
}
    public function mount($salaId)
    {
        $this->salaId = $salaId;
    }
public function render()
{
    $this->sala = Sala::with([
        'point1',
        'point2',
        'point3',
        'point4',
    ])->find($this->salaId);

    $ultimo = null;
    $polling = true;
    $completos = 0;

    for ($i = 4; $i >= 1; $i--) {
        $campoImagenes = "imagepoint$i";
        $nombreRelacion = "point$i";

        if ($this->sala && $this->sala->$campoImagenes) {
            $imagenes = json_decode($this->sala->$campoImagenes, true);

            if (!empty($imagenes)) {
                $completos++; // cuenta los puntos con imagen

                // Solo asignar el último una vez
                if (!$ultimo) {
                    $jugador = $this->sala->getRelationValue($nombreRelacion);

                    $ultimo = [
                        'jugador' => optional($jugador)->username ?? optional($jugador)->nameuser ?? 'Desconocido',
                        'imagenes' => $imagenes,
                        'numero' => $i,
                        'esGanador' => $this->sala->ganador === $nombreRelacion,
                    ];
                }
            }
        }
    }

    // Desactivar polling si hay un ganador o los 4 puntos completaron imagen
    if ($this->sala->ganador || $completos >= 4) {
        $this->pollDelay = null;
    } else {
        $this->pollDelay = '8s';
    }

    return view('livewire.sala-live', [
        'ultimo' => $ultimo,
        'polling' => $polling,
        'sala' => $this->sala->id,
    ]);
}
}