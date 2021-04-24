<?php

namespace App\Http\Livewire\Invoice;

use Livewire\Component;

class InvoiceSendModal extends Component
{
    public bool $show;
    public array $invoice;
    public $receiver, $headline, $messageBody;

    protected $listeners = ['sendInvoice' => 'openModal'];

    protected array $rules = [
        'receiver' => 'email|required',
        'headline' => 'string|required',
        'messageBody' => 'string|required',
    ];

    protected array $messages = [
        'receiver.required' => 'El. pašto adresas yra privalomas.',
        'headline.required' => 'Antraštė yra privaloma.',
        'messageBody.required' => 'Turinys yra privalomas.',
        'receiver.email' => 'Įveskite teisingą el. pašto adresą',
        'headline.string' => 'Galima įvesti tik tekstą',
        'messageBody.string' => 'Galima įvesti tik tekstą',
    ];

    public function mount() {
        $this->show = false;
        $this->invoice = [];
    }

    public function render()
    {
        return view('livewire.invoice.invoice-send-modal');
    }

    public function openModal(array $invoice) {
        $this->show = true;
        $this->invoice = $invoice;
    }

    public function send() {
        $data = $this->validate();
    }
}
