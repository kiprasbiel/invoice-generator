<?php

namespace App\Http\Livewire\Invoice;

use App\Models\Invoice;
use Livewire\Component;

class InvoiceListItem extends Component
{
    public $invoice;
    public $display;
    public $backgroundColor;
    public $shadow;

    public function mount($invoice){
        $this->invoice = $invoice;
        $this->display = false;
        $this->backgroundColor = 'bg-white';
        $this->shadow = 'shadow-none';
    }
    public function render()
    {
        return view('livewire.invoice.invoice-list-item');
    }

    private function setBackgroundColor(){
        if($this->display){
            $this->backgroundColor = 'bg-gray-100';
            $this->shadow = 'shadow-inner';
        }
        else{
            $this->backgroundColor = 'bg-white';
            $this->shadow = 'shadow-none';
        }
    }

    public function showInvoice($id){
        $invoice = Invoice::find($id);
        $this->invoice = $invoice;
        $this->display = !$this->display;
        $this->setBackgroundColor();
        $this->emit('getInvoice-' . $this->invoice->id, $this->display);
    }
}
