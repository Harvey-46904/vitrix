<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Traits\Listnave;
class ListaNaves extends Component
{
    use Listnave;
    public $lista = [];
    public $bote;
    protected $evento;

    public function mount()
    {
        $this->cargarDatos();
    }
    public function cargarDatos()
    {
        $data = $this->ListNaves();
        $this->lista = $data['lista'];
        $this->bote = $data['Bote'];
        $this->evento = $data['evento'];
    }

    public function render()
    {
        return view('livewire.lista-naves');
    }

    protected $listeners = ['refreshComponent' => 'cargarDatos'];
}
