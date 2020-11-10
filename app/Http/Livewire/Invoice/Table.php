<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.invoice.table', [
            'invoices' => Auth::user()->invoices()->paginate(10),
        ]);
    }
}
