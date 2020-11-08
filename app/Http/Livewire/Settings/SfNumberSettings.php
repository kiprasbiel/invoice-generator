<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class SfNumberSettings extends Component
{
    public $sf_code;

    protected $rules = [
        'sf_code' => 'alpha|required',
    ];

    protected $messages = [
        'sf_code.required' => 'Kodas yra privalomas',
        'sf_code.alpha' => 'Kodas privalo būti sudarytas iš raidžių.',
    ];

    public function render()
    {
        return view('livewire.settings.sf-number-settings');
    }

    public function mount(){
        $user = auth()->user();

        $meta = $user->getSfCodeBeginning();

        if ($meta){
            $jsonMeta = json_decode($meta->value);

            $this->sf_code = $jsonMeta->sf_code;
        }

    }

    public function submit(){
        $data = $this->validate();

        $jsonData = json_encode($data);

        $user = auth()->user();

        // Creating meta
        $user->meta()->updateOrCreate(
            ['name' => 'sfNumberSettings'],
            ['value' => $jsonData]
        );
    }
}
