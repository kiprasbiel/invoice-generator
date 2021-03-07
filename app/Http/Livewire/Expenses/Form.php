<?php

namespace App\Http\Livewire\Expenses;

use App\Http\services\Notifications\Notifications;
use Livewire\Component;

class Form extends Component
{
    use Notifications;

    public $expenseNumber, $date, $currency, $sellerName, $sellerAddress, $sellerCountry, $sellerCode, $sellerVAT;

    public array $productList = [];

    protected array $rules = [
        'expenseNumber' => 'alpha_num',
        'currency' => 'alpha',
        'sellerName' => 'string',
        'sellerAddress' => 'nullable|string',
        'date' => 'date_format:Y-m-d',
        'sellerCode' => 'numeric',
        'sellerVAT' => 'alpha_num|nullable',
        'sellerCountry' => 'string|nullable',
        'productList' => 'array',
        'productList.*.product_name' => 'required',
        'productList.*.product_price' => 'numeric|required_with:productList.*.product_name',
        'productList.*.product_pcs' => 'numeric|required_with:productList.*.product_name',
        'productList.*.pcs_type' => 'string|required_with:productList.*.product_name',
    ];

    public function mount() {
        $this->addProduct();
    }

    public function render() {
        return view('livewire.expenses.form');
    }

    public function create() {
        $data = $this->validate();
        $user = auth()->user();

        $expense = $user->expenses()->create($this->getSellerDataArr($data));

        foreach($data['productList'] as $item) {
            $invoiceItem[] = $expense->items()->create($this->getItemDataArr($item));
        }

        session()->flash('message', $this->newNotification('Sąskaita sėkmingai sukurta'));

        return redirect()->to('/expenses');
    }

    public function addProduct($item = null) {
        if($item) {
            $this->productList[] =
                ['product_name' => $item->name, 'product_price' => $item->price, 'product_pcs' => $item->quantity, 'pcs_type' => $item->unit];
        } else {
            $this->productList[] =
                ['product_name' => '', 'product_price' => '', 'product_pcs' => '', 'pcs_type' => 'vnt.'];
        }
    }

    public function deleteProduct($index) {
        unset($this->productList[$index]);
        $this->productList = array_values($this->productList);
    }


    // TODO: Temporary total_price
    private function getSellerDataArr(array $data): array {
        return [
            'number' => $data['expenseNumber'],
            'seller_name' => $data['sellerName'],
            'seller_code' => $data['sellerCode'],
            'seller_address' => $data['sellerAddress'],
            'seller_vat' => $data['sellerVAT'],
            'date' => $data['date'],
            'seller_country' => $data['sellerCountry'],
            'currency' => $data['currency'],
            'total_price' => 210
        ];
    }

    private function getItemDataArr($item): array {
        return [
            'name' => $item['product_name'],
            'unit' => $item['pcs_type'],
            'quantity' => $item['product_pcs'],
            'price' => $item['product_price'],
        ];
    }
}
