<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sala;
use DB;
class ApuestasVolt extends Component
{
    public $sala_id;
    public $sala;

    protected $listeners = ['actualizarCuotas' => 'cargarSala'];

    public function mount($sala_id)
    {
        $this->sala_id = $sala_id;
        $this->cargarSala();
    }
    public function cargarSala()
    {

    
        $this->sala = Sala::
        join('users as u1', 'salas.player_one', '=', 'u1.id')
        ->join('users as u2', 'salas.plater_two', '=', 'u2.id')
        ->select(
            'salas.*',
            'u1.name as player_one_name',
            'u2.name as player_two_name'
        )
        ->where("salas.id", $this->sala_id)->first();
    }


    public function render()
    {
        return view('livewire.apuestas-volt');
    }
}
