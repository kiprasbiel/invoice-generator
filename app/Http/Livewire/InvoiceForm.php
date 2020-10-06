<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InvoiceForm extends Component
{
    public $companyName;
    public $companyCode;
    public $companyVat;
    public $companyAddress;
    public $productName;
    public $productPrice;
    public $productPcs;
    public $pcsType;

    protected $rules = [
        'companyName' => 'required',
        'companyCode' => 'required',
        'companyVat' => 'required',
        'companyAddress' => 'required',
        'productName' => 'required',
        'productPrice' => 'required',
        'productPcs' => 'required',
        'pcsType' => 'required',
    ];

    public function render()
    {
        return view('livewire.invoice-form');
    }

    public function submit(){
        $this->validate();

    }
}
