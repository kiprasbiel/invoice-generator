<?php

namespace App\Jobs;

use App\Http\services\Clients\ClientImportService;
use App\Http\services\Invoice\InvoiceImportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InvoiceImportProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $file;
    private string $type;
    private array $data;

    /**
     * Create a new job instance.
     *
     * @param string $file
     * @param array $data
     * @param string $type
     */

    public function __construct(string $file, array $data, string $type) {
        $this->file = $file;
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        if($this->type === 'clients') {
            $service = new ClientImportService();
            $service->import($this->file, $this->data);
        } else if($this->type === 'invoices') {
            $service = new InvoiceImportService();
            $service->import($this->file);
        }
    }
}
