<?php

namespace App\Http\Livewire\Expenses;

use App\Http\services\Notifications\Notifications;
use Livewire\Redirector;
use Livewire\Component;

class Form extends Component
{
    use Notifications;

    public $expenseNumber, $date, $currency, $sellerName, $sellerAddress, $sellerCountry, $sellerCode, $sellerVAT;

    public $productList = [];

    protected $rules = [
        'expenseNumber' => 'alpha_num',
        'currency' => 'alpha',
        'sellerName' => 'string',
        'sellerAddress' => 'nullable|string',
        'date' => 'date_format:Y-m-d',
        'sellerCode' => 'numeric',
        'sellerVAT' => 'alpha_num|nullable',
        'sellerCountry' => 'string|nullable',
    ];

    public function render() {
        return view('livewire.expenses.form');
    }

    public function create() {
        $data = $this->validate();
        $user = auth()->user();

        $user->expenses()->create($this->getSellerDataArr($data));


        return redirect()->to('/expenses');
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
}
