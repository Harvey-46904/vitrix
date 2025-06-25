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
    $this->sala = Sala::find($this->salaId);

    $ultimo = null;
    $polling = true; // por defecto sí

    for ($i = 4; $i >= 1; $i--) {
        $campoImagenes = "imagepoint$i";
        $campoJugador = "point$i";

        if ($this->sala && $this->sala->$campoImagenes) {
            $imagenes = json_decode($this->sala->$campoImagenes, true);

            if (!empty($imagenes)) {
                $ultimo = [
                    'jugador' => $this->sala->$campoJugador,
                    'imagenes' => $imagenes,
                    'numero' => $i,
                    'esGanador' => $this->sala->ganador === "point$i",
                ];
                break;
            }
        }
    }
   

    if ($this->sala->ganador) {
        $this->pollDelay = null; // desactiva el polling
    } else {
        $this->pollDelay = '8s';
    }

    return view('livewire.sala-live', [
        'ultimo' => $ultimo,
        'polling' => $polling,
        'sala'=>$this->sala->id,
    ]);
}
}