<?php

namespace App\Http\Livewire;

use App\Http\services\pdf\PdfGenerator;
use Livewire\Component;

class InvoiceForm extends Component
{
    public $companyName;
    public $companyCode;
    public $companyVat;
    public $companyAddress;

    public $productList = [];

    protected $rules = [
        'companyName' => 'required|string',
        'companyCode' => 'required|numeric',
        'companyVat' => 'alpha_num|nullable',
        'companyAddress' => 'nullable',
        'productList' => 'array',
        'productList.*.product_name' => 'required',
        'productList.*.product_price' => 'numeric|required_with:productList.*.product_name',
        'productList.*.product_pcs' => 'numeric|required_with:productList.*.product_name',
        'productList.*.pcs_type' => 'string|required_with:productList.*.product_name',
    ];

    protected $messages = [
        'companyName.required' => 'Įmonės pavadinimas yra privalomas.',
        'companyName.string' => 'Įmonės pavadinimas turi būti sudarytas iš raidžių ir simbolių.',
        'companyCode.required' => 'Įmonės kodas yra privalomas.',
        'companyCode.numeric' => 'Įmonės kodas privalo būti sudarytas iš skaičių.',
        'companyVat.alpha_num' => 'PVM kodas gali būti sudarytas iš raidžių ir skaičių.',
        'productList.*.product_name.required' => 'Produkto pavadinimas yra privalomas.',
        'productList.*.product_price.numeric' => 'Produkto kaina privalo būti sudaryta iš skaičių.',
        'productList.*.product_price.required_with' => 'Produkto kaina yra privaloma.',
        'productList.*.product_pcs.numeric' => 'Produkto kiekis privalo būti sudarytas iš skaičių.',
        'productList.*.product_pcs.required_with' => 'Produkto kiekis yra privalomas.',
        'productList.*.pcs_type.string' => 'Produkto vienetai privalo būti sudaryti iš raidžių ir simbolių.',
        'productList.*.pcs_type.required_with' => 'Produkto vienetai yra privalomi.',
    ];

    public function mount()
    {
        $this->productList = [
            ['product_name' => '', 'product_price' => '', 'product_pcs' => '', 'pcs_type' => 'vnt.']
        ];
    }

    public function render()
    {
        return view('livewire.invoice-form');
    }

    public function addProduct()
    {
        $this->productList[] =
            ['product_name' => '', 'product_price' => '', 'product_pcs' => '', 'pcs_type' => 'vnt.'];
    }

    public function deleteProduct($index){
        unset($this->productList[$index]);
        $this->productList = array_values($this->productList);
    }

    public function submit()
    {
        $data = $this->validate();
//        dd($this->productList);
        dd($data);
        $pdfGenerator = new PdfGenerator();
        return $pdfGenerator->generatePdf($data);
    }
}
