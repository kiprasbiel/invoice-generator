<?php

namespace App\Http\Livewire;

use App\Http\services\pdf\pdfGenerator;
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
    ];

    public function __construct($id = null)
    {
        parent::__construct($id);
    }

    public function render()
    {
        return view('livewire.invoice-form');
    }

    public function submit(){
        $this->validate();
        $pdfGenerator = new pdfGenerator();
        return $pdfGenerator->generatePdf();
    }
}
