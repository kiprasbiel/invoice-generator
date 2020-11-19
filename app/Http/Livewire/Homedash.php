<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Homedash extends Component
{
    public $income;
    public $expenses;
    public $totalTax;

    public $gpm;
    public $psd;
    public $vsd;

    public function render()
    {
        return view('livewire.homedash');
    }

    public function mount(){
        $user = auth()->user();

        $this->income = $user->getTotalIncome();
        $this->expenses = $user->getTotalExpenses();
        $this->totalTax = $user->getTotalTax();

        $this->gpm = $user->getGPM();
        $this->psd = $user->getPSD();
        $this->vsd = $user->getVSD();
    }
}
