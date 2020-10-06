<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Homedash extends Component
{
    public $testVar = "Home dash component";

    public function render()
    {
        return view('livewire.homedash');
    }
}
