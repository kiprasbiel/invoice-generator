<?php

namespace App\Http\Livewire\Settings;

use App\Http\services\Notifications\Notifications;
use Livewire\Component;
use Livewire\WithFileUploads;

class InvoiceImport extends Component
{
    use WithFileUploads, Notifications;

    public $file;

    public function render() {
        return view('livewire.settings.invoice-import');
    }

    public function submit() {
        $this->validate([
            'file' => 'file|max:1024',
        ]);

        $this->file->storeAs('/', 'testas.csv', $disk = 'invoices');
        $this->dispatchBrowserEvent('notify', $this->newNotification('Failas sėkmingai įkeltas'));
    }
}
