<?php

namespace Tests\Feature;

use App\Http\Livewire\Settings\InvoiceImport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class IvoiceImportTest extends TestCase
{
    public function testCanUploadInvoiceFile() {
        Storage::fake('invoices');

        $file = UploadedFile::fake()->createWithContent('testas.csv', 'Labas vakaras, mieli kolegos');

        Livewire::test(InvoiceImport::class)
            ->set('file', $file)
            ->call('submit', 'testas.csv');

        Storage::disk('invoices')->assertExists('testas.csv');
    }

}
