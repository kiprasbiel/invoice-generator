<?php

namespace App\Http\Livewire;

use App\Http\services\pdf\PdfGenerator;
use Livewire\Component;
use Livewire\Request;
use phpDocumentor\Reflection\Types\This;

class InvoiceForm extends Component
{
    public $companyName;
    public $companyCode;
    public $companyVat;
    public $companyAddress;
//    public $productName;
//    public $productPrice;
//    public $productPcs;
//    public $pcsType;

    public $productList = [];

    protected $rules = [
        'companyName' => 'required|string',
        'companyCode' => 'required|numeric',
        'companyVat' => 'alpha_num|nullable',
        'companyAddress' => 'nullable',
        'productList' => 'array',
        'productList.*.product-name' => 'string|required_with:productList.*.product-price|required_with:productList.*.product-pcs|required_with:productList.*.pcs-type',
        'productList.*.product-price' => 'numeric|required_with:productList.*.product-name',
        'productList.*.product-pcs' => 'numeric|required_with:productList.*.product-name',
        'productList.*.pcs-type' => 'numeric|required_with:productList.*.product-name',
    ];

    public function mount()
    {
        $this->productList = [
            ['pcs-type' => 'vnt.']
        ];
    }

    public function render()
    {
        return view('livewire.invoice-form');
    }

    public function addProduct()
    {
        $this->productList[] = ['pcs-type' => 'vnt.'];
    }

    public function deleteProduct($index){
        unset($this->productList[$index]);
        $this->productList = array_values($this->productList);
    }

    public function submit()
    {
        $data = $this->validate();
        $pdfGenerator = new PdfGenerator();
        return $pdfGenerator->generatePdf($data);
    }
}
