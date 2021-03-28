<?php

namespace App\Http\Livewire;

use App\Http\services\Notifications\Notifications;
use App\Jobs\InvoiceImportProcessor;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ParseImport extends Component
{
    use Notifications;

    protected $listeners = ['modelImport'];

    // TODO: write a custom validation
    protected $rules = [
        'fields' => 'array',
    ];

    public array $csvData;
    public bool $show;
    public array $dbColNames;
    public string $maxWidth;
    public array $fields = [];

    public int $importId;

    public function render() {
        // TODO: Parasyt paaiskinima, kokie field'ai gali buti uzpildomi
        return view('livewire.parse-import');
    }

    public function mount() {
        $this->show = false;
        $this->csvData = [];
        $this->dbColNames = ['null'];
        $this->maxWidth = 'sm';
    }

    // TODO: Rasant ataskaita reikes butinai kaip saltini paminet
    public function modelImport($fileName, $hasHeader) {
        $user = auth()->user();

        $client = new Client();
        $this->dbColNames = array_merge($this->dbColNames, $client->getFillable());

        // TODO: gal net cia geriau saugot i db
        $filePath = Storage::disk('invoices')->path($fileName);

        $savedData = $user->importData()->create([
            'csv_filename' => $filePath
        ]);

        $this->importId = $savedData->id;

        $data = array_map(
            function($file) {
                return str_getcsv($file, ";");
            },
            file($filePath)
        );

        if(count($data) > 0) {
            $this->csvData = array_slice($data, 0, 2);
            $this->show = true;
        }
    }

    public function startImport($id) {
        $data = $this->validate();
        if(($key = array_search('null', $data)) !== false) {
            unset($data[$key]);
        }

        InvoiceImportProcessor::dispatch($id, $data, 'clients');
        $this->dispatchBrowserEvent('notify', $this->newNotification('Importas pradėtas'));
    }
}
