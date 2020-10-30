<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class IvPersonalInfo extends Component
{
    public $full_name;
    public $iv_code;
    public $personal_code;
    public $address;
    public $phone;
    public $email;
    public $additional_info;
    public $bank_name;
    public $bank_account_num;
    public $vat;

    //TODO: prideti ivestos info ilgiu tikrinimus
    protected $rules = [
        'full_name' => 'string|required',
        'iv_code' => 'numeric|nullable',
        'personal_code' => 'numeric|nullable',
        'address' => 'string|nullable',
        'phone' => 'string|nullable',
        'email' => 'email|nullable',
        'additional_info' => 'string|nullable',
        'bank_name' => 'string|nullable',
        'bank_account_num' => 'alpha_num|nullable',
        'vat' => 'alpha_num|nullable',
    ];

    protected $messages = [
        'full_name.required' => 'Vardas ir pavardė yra privalomi.',
        'full_name.string' => 'Vardas ir pavardė turi būti sudaryti iš raidžių ir simbolių.',
        'iv_code.numeric' => 'IV kodas privalo būti sudarytas iš skaičių.',
        'personal_code.numeric' => 'Asmens kodas privalo būti sudarytas iš skaičių.',
        'vat.alpha_num' => 'PVM kodas privalo būti sudarytas iš raidžių ir skaičių.',
        'address.string' => 'Adresas turi būti sudarytas iš raidžių ir simbolių.',
        'phone.string' => 'Telefonas turi būti sudarytas iš raidžių ir simbolių.', //TODO: Turi but normalus tikrinimas ir paaiskinimas
        'email.email' => 'Prašome įvesti teisingą el. pašto adresą',
        'bank_account_num.alpha_num' => 'Banko sąskaita privalo būti sudarytas iš raidžių ir skaičių.'
    ];

    public function render()
    {
        return view('livewire.settings.iv-personal-info');
    }

    public function mount(){
        $user = auth()->user();

        $meta = $user->getActivitySettings();

        // TODO: Prideti zynute kuri butu rodoma kuomet vartotojas neturi dar susivedes nustatymu
        // TODO: Jei vartotojas neturi susivedes nustatymu, tuomet atvaizduoti kai kuriuose laukeliuose info is jo paskyros
        if ($meta){
            $jsonMeta = json_decode($meta->value);

            $this->full_name = $jsonMeta->full_name;
            $this->iv_code = $jsonMeta->iv_code;
            $this->personal_code = $jsonMeta->personal_code;
            $this->address = $jsonMeta->address;
            $this->phone = $jsonMeta->phone;
            $this->email = $jsonMeta->email;
            $this->bank_name = $jsonMeta->bank_name;
            $this->bank_account_num = $jsonMeta->bank_account_num;
            $this->vat = $jsonMeta->vat;
            $this->additional_info = $jsonMeta->additional_info;
        }

    }

    public function submit(){
        $data = $this->validate();

        $jsonData = json_encode($data);

        $user = auth()->user();

        // Creating meta
        $user->meta()->updateOrCreate(
            ['name' => 'userActivitySettings'],
            ['value' => $jsonData]
        );
    }
}
