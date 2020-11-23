<?php

namespace App\Http\Livewire\Settings;

use App\Models\Meta;
use Livewire\Component;

class Privileges extends Component
{
    // TODO: Select'us tvarkyt kaip viena array. Taip nebus false.
    public $isStudent;
    public $isFirstTimer;
    public $isPensioner;
    public $additionalPension;

    public $pensionsTypes = [];

    protected $rules = [];

    public function __construct($id = null) {
        parent::__construct($id);
        $this->rules = Meta::getFieldsForValidation('Privileges', 'nullable');
    }

    public function render()
    {
        return view('livewire.settings.privileges');
    }

    public function mount(){
        $user = auth()->user();

        $meta = $user->getPrivilegesSettings();
        if($meta){
            $jsonMeta = json_decode($meta->value);

            $this->isStudent = $jsonMeta->isStudent;
            $this->isFirstTimer = $jsonMeta->isFirstTimer;
            $this->isPensioner = $jsonMeta->isPensioner;
            $this->additionalPension = $jsonMeta->additionalPension;
        }

        $this->pensionsTypes = [
            'pens0' => 'Nekaupiu',
            'pens21' => '2,1 proc.',
            'pens3' => '3,1 proc.',
        ];
    }

    public function submit(){
        $data = $this->validate();
        $jsonData = json_encode($data);
        $user = auth()->user();
        $user->meta()->updateOrCreate(
            ['name' => 'privilegesSettings'],
            ['value' => $jsonData]
        );
    }
}
