<?php

namespace App\Http\Livewire\Settings;

use App\Http\services\Notifications\Notifications;
use App\Models\Meta;
use Livewire\Component;

class SfNumberSettings extends Component
{
    use Notifications;

    public $sf_code;

    protected $rules = [];

    public function __construct($id = null) {
        parent::__construct($id);
        $this->rules = array_merge(Meta::getFieldsForValidation('SfCode'), [
            'sf_code' => 'alpha|required',
        ]);
    }

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

        $meta = $user->getSfCodeBeginning(true);
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

        $this->dispatchBrowserEvent('notify', $this->newNotification('Nustatymai išsaugoti'));
    }
}
