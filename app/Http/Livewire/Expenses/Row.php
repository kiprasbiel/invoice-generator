<?php

namespace App\Http\Livewire\Expenses;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Row extends Component
{
    public Model $expense;

    public function render() {
        return view('livewire.expenses.row');
    }

    public function mount(Model $expense) {
        $this->expense = $expense;
    }
}
