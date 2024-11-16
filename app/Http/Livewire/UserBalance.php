<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UserBalance extends Component
{
    public $efectivo;
    public $inversion;
    public $referidos;
    public $bonos;

    protected $listeners = ['echo:balance-updated, BalanceUpdated' => 'refreshBalances'];

    public function mount()
    {
        $this->loadBalances();
    }

    public function refreshBalances()
    {
        $this->loadBalances();
    }

    private function loadBalances()
    {
        $user = auth()->user();
        $this->efectivo = $user->balance_general->balance;
        $this->inversion = $user->balance_inversion->balance;
        $this->referidos = $user->balance_ibox->balance;
        $this->bonos = $user->balance_bono->balance;
    }

    public function render()
    {
        return view('livewire.user-balance');
    }

   
}
