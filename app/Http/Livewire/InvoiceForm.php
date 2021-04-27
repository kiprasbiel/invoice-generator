<?php

namespace App\Http\Livewire;

use App\Http\services\Notifications\Notifications;
use Carbon\Carbon;
use Livewire\Component;

class InvoiceForm extends Component
{
    use Notifications;

    public $companyName, $companyCode, $companyVat, $companyAddress, $invoice, $action, $payBy, $email, $userSettings, $sf_code, $invoiceDate;

    public $productList = [];

    protected $rules = [
        'companyName' => 'required|string',
        'companyCode' => 'required|numeric',
        'companyVat' => 'alpha_num|nullable',
        'companyAddress' => 'nullable',
        'payBy' => 'nullable|date_format:Y-m-d',
        'email' => 'nullable|email',
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
        'payBy.date_format' => 'Netinkamas datos formatas',
        'email.email' => 'Įvestas el. pašto adresas neteisingas',

        'productList.*.product_name.required' => 'Produkto pavadinimas yra privalomas.',
        'productList.*.product_price.numeric' => 'Produkto kaina privalo būti sudaryta iš skaičių.',
        'productList.*.product_price.required_with' => 'Produkto kaina yra privaloma.',
        'productList.*.product_pcs.numeric' => 'Produkto kiekis privalo būti sudarytas iš skaičių.',
        'productList.*.product_pcs.required_with' => 'Produkto kiekis yra privalomas.',
        'productList.*.pcs_type.string' => 'Produkto vienetai privalo būti sudaryti iš raidžių ir simbolių.',
        'productList.*.pcs_type.required_with' => 'Produkto vienetai yra privalomi.',
    ];

    public function mount(object $invoice = null) {
        $this->invoice = $invoice;
        $user = auth()->user();
        $this->userSettings = $user->getDecodedUserSettings('userActivitySettings', null, true);


        // Editing existing invoice
        if($this->invoice) {
            $this->action = 'update';

            $this->sf_code = $invoice->sf_code;
            $this->invoiceDate = $invoice->created_at->format('Y-m-d');
            $this->companyName = $invoice->company_name;
            $this->companyCode = $invoice->company_code;
            $this->companyVat = $invoice->company_vat;
            $this->companyAddress = $invoice->company_address;
            if($invoice->pay_by){
                $this->payBy = $invoice->pay_by->format('Y-m-d');
            }
            $this->email = $invoice->email;

            $itemCollection = $this->invoice->items;
            foreach($itemCollection as $item) {
                $this->addProduct($item);
            }
        } // New invoice
        else {
            $this->sf_code = $user->getSfCode();
            $this->invoiceDate = Carbon::now()->format('Y-m-d');
            $this->action = 'create';
            $this->addProduct();
        }
    }

    public function render() {
        return view('livewire.invoice-form');
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

    public function create() {
        $data = $this->validate();
        $user = auth()->user();

        $invoice = $user->invoices()->create($this->getCompanyDataArr($data));

        foreach($data['productList'] as $item) {
            $invoiceItem[] = $invoice->items()->create($this->getItemDataArr($item));
        }

        $invoice->downloadInvoice();

        session()->flash('message', $this->newNotification('Sąskaita sėkmingai sukurta'));

        return redirect()->to('/invoice');
    }

    public function update() {
        $data = $this->validate();

        $this->invoice->update($this->getCompanyDataArr($data));

        // Delete all items
        $this->invoice->items()->delete();

        // Create new items
        foreach($data['productList'] as $item) {
            $invoiceItem[] = $this->invoice->items()->create($this->getItemDataArr($item));
        }

        $this->dispatchBrowserEvent('notify', $this->newNotification('Sąskaita sėkmingai atnaujinta'));
    }

    /**
     * Company data fields
     *
     * @param array $data
     * @return array
     */
    private function getCompanyDataArr(array $data): array {
        return [
            'company_name' => $data['companyName'],
            'company_code' => $data['companyCode'],
            'company_address' => $data['companyAddress'],
            'company_vat' => $data['companyVat'],
            'pay_by' => $data['payBy'],
            'email' => $data['email'],
        ];
    }

    /**
     * Invoice items data fields
     *
     * @param $item
     * @return array
     */
    private function getItemDataArr($item): array {
        return [
            'name' => $item['product_name'],
            'unit' => $item['pcs_type'],
            'quantity' => $item['product_pcs'],
            'price' => $item['product_price'],
        ];
    }
}
