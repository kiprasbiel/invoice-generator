<?php

namespace App\Http\Livewire\Invoice;

use Livewire\Component;

class InvoiceInfo extends Component
{
    public $invoice;
    public $items;

    public $display;


    protected function getListeners()
    {
        $listenerName = 'getInvoice-' . $this->invoice->id;
        return [$listenerName => 'getInvoice'];
    }

    private function setDisplayState(bool $state){
        $this->display = ($state) ? 'block' : 'hidden';
    }

    public function mount($invoice){
        $this->display = 'hidden';
        $this->invoice = $invoice;
    }

    public function render()
    {
        return view('livewire.invoice.invoice-info');
    }

    public function getInvoice($state){
        $this->items = $this->invoice->invoiceItems;
        $this->setDisplayState($state);
    }


}
