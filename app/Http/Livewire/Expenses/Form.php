<?php

namespace App\Http\Livewire\Expenses;

use App\Http\services\Notifications\Notifications;
use Livewire\Component;

class Form extends Component
{
    use Notifications;

    public $expenseNumber, $date, $currency, $sellerName, $sellerAddress, $sellerCode, $sellerVAT;

    public string $action;

    public $expense;

    public array $productList = [];

    protected array $rules = [
        'expenseNumber' => 'alpha_num',
        'currency' => 'alpha',
        'sellerName' => 'string',
        'sellerAddress' => 'nullable|string',
        'date' => 'date_format:Y-m-d',
        'sellerCode' => 'numeric',
        'sellerVAT' => 'alpha_num|nullable',
        'productList' => 'array',
        'productList.*.product_name' => 'required',
        'productList.*.product_price' => 'numeric|required_with:productList.*.product_name',
        'productList.*.product_pcs' => 'numeric|required_with:productList.*.product_name',
        'productList.*.pcs_type' => 'string|required_with:productList.*.product_name',
    ];

    public function mount($expense = null) {
        // Editing existing expense
        if($expense) {
            $this->action = 'update';

            $this->sellerName = $expense->seller_name;
            $this->sellerCode = $expense->seller_code;
            $this->sellerVAT = $expense->seller_vat;
            $this->sellerAddress = $expense->seller_address;
            $this->expenseNumber = $expense->number;
            $this->currency = $expense->currency;
            // TODO: neveikia
            $this->date = $expense->date;

            $itemCollection = $this->expense->items;
            foreach($itemCollection as $item) {
                $this->addProduct($item);
            }
        } // New expense
        else {
            $this->action = 'create';
            $this->addProduct();
        }
    }

    public function render() {
        return view('livewire.expenses.form');
    }

    public function create() {
        $data = $this->validate();
        $user = auth()->user();

        $expense = $user->expenses()->create($this->getSellerDataArr($data));

        foreach($data['productList'] as $item) {
            $expense->items()->create($this->getItemDataArr($item));
        }

        session()->flash('message', $this->newNotification('Išlaida sėkmingai pridėta'));

        return redirect()->to('/expenses');
    }

    public function update() {
        $data = $this->validate();

        $this->expense->update($this->getSellerDataArr($data));

        // Delete all items
        $this->expense->items()->delete();

        // Create new items
        foreach($data['productList'] as $item) {
            $invoiceItem[] = $this->expense->items()->create($this->getItemDataArr($item));
        }

        $this->dispatchBrowserEvent('notify', $this->newNotification('Išlaida sėkmingai atnaujinta'));
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


    private function getSellerDataArr(array $data): array {
        return [
            'number' => $data['expenseNumber'],
            'seller_name' => $data['sellerName'],
            'seller_code' => $data['sellerCode'],
            'seller_address' => $data['sellerAddress'],
            'seller_vat' => $data['sellerVAT'],
            'date' => $data['date'],
            'currency' => $data['currency'],
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
