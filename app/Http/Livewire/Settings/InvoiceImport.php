<?php

namespace App\Http\Livewire\Settings;

use App\Http\services\Notifications\Notifications;
use Livewire\Component;
use Livewire\WithFileUploads;

class InvoiceImport extends Component
{
    use WithFileUploads, Notifications;

    public $file;
    public $hasHeader;

    public function render() {
        return view('livewire.settings.invoice-import');
    }

    public function parse() {
        $data = $this->validate([
            'file' => 'file|max:1024|mimes:csv,txt',
            'hasHeader' => 'nullable|boolean'
        ]);

        $fileName = $this->file->store('/', $disk = 'invoices');

        $this->emit('modelImport', $fileName, $data['hasHeader']);
    }
}
