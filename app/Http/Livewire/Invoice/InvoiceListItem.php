<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Invoice;
use Livewire\Component;

class InvoiceListItem extends Component
{
    public $invoice;
    public $display;

    public function mount($invoice){
        $this->invoice = $invoice;
        $this->display = false;
    }
    public function render()
    {
        return view('livewire.invoice.invoice-list-item');
    }

    public function showInvoice($id){
        $invoice = Invoice::find($id);
        $this->invoice = $invoice;
        $this->display = !$this->display;
        $this->emit('getInvoice-' . $this->invoice->id, $this->display);
    }
}
