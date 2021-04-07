<?php

namespace Tests\Feature;

use App\Http\Livewire\Settings\InvoiceImport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class InvoiceImportTest extends TestCase
{
    public function testCanUploadInvoiceFile() {
        $this->withoutExceptionHandling();
        Storage::fake('invoices');

        $file = UploadedFile::fake()->createWithContent('testas.csv', 'Labas vakaras, mieli kolegos');

        $fileName = Livewire::test(InvoiceImport::class)
            ->set('file', $file)
            ->set('hasHeader', false)
            ->set('type', 'Invoice')
            ->call('parse')
            ->get('fileName');

        Storage::disk('invoices')->assertExists($fileName);
    }

}
