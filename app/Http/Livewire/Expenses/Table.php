<?php

namespace App\Http\Livewire\Expenses;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Table extends Component
{
    public function render() {
        return view('livewire.expenses.table', [
            'expenses' => Auth::user()->expenses()->orderByDesc('id')->paginate(10),
        ]);
    }
}
