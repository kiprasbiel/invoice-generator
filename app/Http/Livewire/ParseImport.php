<?php

namespace App\Http\Livewire;

use App\Http\services\Notifications\Notifications;
use App\Jobs\InvoiceImportProcessor;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ParseImport extends Component
{
    use Notifications;

    protected $listeners = ['modelImport'];

    // TODO: write a custom validation
    // Cant be two fields with the same value.
    protected $rules = [
        'fields' => 'array',
    ];

    public array $csvData;
    public bool $show;
    public array $dbColNames;
    public array $fields = [];

    public int $importId;
    public string $type;

    public function render() {
        // TODO: Parasyt paaiskinima, kokie field'ai gali buti uzpildomi
        return view('livewire.parse-import');
    }

    public function mount() {
        $this->show = false;
        $this->csvData = [];
        $this->dbColNames = [];
        $this->type = 'Invoice';
    }

    // TODO: Rasant ataskaita reikes butinai kaip saltini paminet
    // Headerio dar nehandlinam
    public function modelImport($fileName, $hasHeader, $type) {
        $user = auth()->user();
        $className = 'App\Models\\' . $type;
        $model = new $className;
        $this->dbColNames = array_merge($this->dbColNames, $model->getFillableForImport());

        if($type === 'Invoice') {
            $item = new Item;
            $this->dbColNames = array_merge($this->dbColNames, $item->getFillableForImport());
        }

        // TODO: gal net cia geriau saugot i db
        $filePath = Storage::disk('invoices')->path($fileName);

        $savedData = $user->importData()->create([
            'csv_filename' => $filePath,
            'type' => $type,
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

        InvoiceImportProcessor::dispatch($id, $data);
        $this->dispatchBrowserEvent('notify', $this->newNotification('Importas pradėtas'));
    }
}
