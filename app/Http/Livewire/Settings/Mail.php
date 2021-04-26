<?php

namespace App\Http\Livewire\Settings;

use App\Http\services\Notifications\Notifications;
use App\Models\Meta;
use Livewire\Component;

class Mail extends Component
{
    use Notifications;

    public $sender;
    public $headline;
    public $messageBody;
    public $autoSend;

    protected array $rules = [];

    public function __construct($id = null) {
        parent::__construct($id);
        $this->rules = array_merge(Meta::getFieldsForValidation('Mail'), [
            'autoSend' => 'boolean|required',
            'sender' => 'email|required',
            'headline' => 'string|required',
            'messageBody' => 'string|required',
        ]);
    }

    public function render() {
        return view('livewire.settings.mail');
    }

    public function mount() {
        $user = auth()->user();

        $meta = $user->getMailSettings();
        if ($meta) {
            $this->autoSend = $meta->autoSend;
            $this->sender = $meta->sender;
            $this->headline = $meta->headline;
            $this->messageBody = $meta->messageBody;
        }
    }

    public function submit() {
        $data = $this->validate();

        $jsonData = json_encode($data);

        $user = auth()->user();

        $user->meta()->updateOrCreate(
            ['name' => 'mailSettings'],
            ['value' => $jsonData]
        );

        $this->dispatchBrowserEvent('notify', $this->newNotification('Nustatymai išsaugoti'));
    }
}
