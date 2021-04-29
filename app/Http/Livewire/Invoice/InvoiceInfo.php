<?php

namespace App\Http\Livewire\Invoice;

use Livewire\Component;

class InvoiceInfo extends Component
{
    public $invoice;
    public $items;

    public $display;
    public $is_payed;


    protected function getListeners(): array {
        $listenerName = 'getInvoice-' . $this->invoice->id;
        return [$listenerName => 'getInvoice'];
    }

    private function setDisplayState(bool $state){
        $this->display = ($state) ? 'table-row' : 'hidden';
    }

    public function mount($invoice){
        $this->display = 'hidden';
        $this->invoice = $invoice;
        $this->is_payed = $invoice->is_payed;
    }

    public function render()
    {
        return view('livewire.invoice.invoice-info');
    }

    // Used for listeners
    public function getInvoice($state){
        $this->items = $this->invoice->items;
        $this->setDisplayState($state);
    }

    public function delete(){
        $this->display = 'hidden';
        $this->emit('delete-' . $this->invoice->id);
    }

    public function download(){
        return $this->invoice->downloadInvoice();
    }

    public function send() {
        $this->emit('sendInvoice', $this->invoice);
    }

    public function updatedIsPayed($value) {
        $this->invoice->update(['is_payed' => (bool)$value]);
        $this->emit("toggleIsPayed-{$this->invoice->id}", $value);
    }

}
