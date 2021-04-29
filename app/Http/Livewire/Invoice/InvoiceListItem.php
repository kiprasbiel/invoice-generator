<?php

namespace App\Http\Livewire\Invoice;

use App\Http\services\Notifications\Notifications;
use App\Models\Invoice;
use Livewire\Component;

class InvoiceListItem extends Component
{
    use Notifications;

    public $invoice;
    public $display;
    public $backgroundColor;
    public $shadow;
    public $displayH;
    public $is_payed;

    public $hamburger;
    public $closeSection;

    protected function getListeners() {
        $listenerName = 'delete-' . $this->invoice->id;
        $toggleListener = "toggleIsPayed-{$this->invoice->id}";

        return [
            $listenerName => 'removeRow',
            $toggleListener => 'toggleIsPayed',
        ];
    }

    public function mount($invoice) {
        $this->invoice = $invoice;
        $this->display = false;
        $this->backgroundColor = 'bg-white';
        $this->shadow = 'shadow-none';
        $this->hamburger = 'inline-flex';
        $this->closeSection = 'hidden';
        $this->displayH = 'table-row';
        $this->is_payed = $invoice->is_payed;
    }

    public function render() {
        return view('livewire.invoice.invoice-list-item');
    }

    private function setBackgroundColor() {
        if($this->display) {
            $this->backgroundColor = 'bg-gray-100';
            $this->shadow = 'shadow-inner';
            $this->hamburger = 'hidden';
            $this->closeSection = 'inline-flex';
        } else {
            $this->backgroundColor = 'bg-white';
            $this->shadow = 'shadow-none';
            $this->hamburger = 'inline-flex';
            $this->closeSection = 'hidden';
        }
    }

    public function showInvoice($id) {
        $invoice = Invoice::find($id);
        $this->invoice = $invoice;
        $this->display = !$this->display;
        $this->setBackgroundColor();
        $this->emit('getInvoice-' . $this->invoice->id, $this->display);
    }

    public function removeRow() {
        $this->display = !$this->display;
        $this->setBackgroundColor();
        $this->displayH = 'hidden';
        $this->invoice->delete();

        $this->dispatchBrowserEvent('notify', $this->newNotification('Sąskaita sėkmingai pašalinta'));
    }

    public function toggleIsPayed($value) {
        $this->is_payed = $value;
    }
}
