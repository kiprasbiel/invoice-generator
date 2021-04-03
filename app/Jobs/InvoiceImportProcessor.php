<?php

namespace App\Jobs;

use App\Http\services\Clients\ClientImportService;
use App\Http\services\Invoice\InvoiceImportService;
use App\Models\ImportData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InvoiceImportProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $file;
    private array $data;

    /**
     * Create a new job instance.
     *
     * @param string $file
     * @param array $data
     */

    public function __construct(string $file, array $data) {
        $this->file = $file;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $importData = ImportData::find($this->file);

        if($importData->type === 'Client') {
            $service = new ClientImportService();
            $service->import($importData, $this->data);
        } else if($importData->type === 'Invoice') {
            $service = new InvoiceImportService();
            $service->import($importData, $this->data);
        }
    }
}
