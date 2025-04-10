<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Traits\Listnave;
class ListaNaves extends Component
{
    use Listnave;
    public $lista = [];
   
    protected $evento;


    public $bote = 0;
    public $boteAnterior = 0;
    public $animarBote = false;
    public $boteDiferencia = 0;
    public function mount()
    {
        $this->cargarDatos();
    }
    public function cargarDatos()
    {
        $data = $this->ListNaves();
        $nuevoBote = $data['Bote'];
        $this->boteDiferencia = $nuevoBote > $this->bote ? $nuevoBote - $this->bote : 0;
        $this->animarBote = $this->boteDiferencia > 0;
        $this->boteAnterior = $this->bote;
        $this->lista = $data['lista'];
        $this->bote = $nuevoBote;
        $this->evento = $data['evento'];
    }
    public function updatedBote()
    {
        if ($this->animarBote) {
            $this->dispatchBrowserEvent('resetAnimacionBote');
        }
    }
    public function render()
    {
        return view('livewire.lista-naves');
    }

    protected $listeners = ['refreshComponent' => 'cargarDatos'];
}
