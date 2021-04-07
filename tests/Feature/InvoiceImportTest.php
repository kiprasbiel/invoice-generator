<?php

namespace Tests\Feature;

use App\Http\Livewire\Settings\InvoiceImport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class InvoiceImportTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $user;

    protected function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    protected function tearDown(): void {
        parent::tearDown();

        $this->user = NULL;
    }

    public function testCanUploadInvoiceFile() {
        $this->withoutExceptionHandling();
        Storage::fake('invoices');

        $file = UploadedFile::fake()->createWithContent('testas.csv', 'Labas vakaras, mieli kolegos');

        $fileName = Livewire::test(InvoiceImport::class)
            ->set('file', $file)
            ->set('hasHeader', false)
            ->set('type', 'Invoice')
            ->call('parse')
            ->assertEmitted('modelImport')
            ->get('fileName');

        Storage::disk('invoices')->assertExists($fileName);
    }

    function test_activity_page_contains_parse_import_component() {
        $this->get('/activity')->assertSeeLivewire('parse-import');
    }

    function test_activity_page_contains_invoice_import_component() {
        $this->get('/activity')->assertSeeLivewire('settings.invoice-import');
    }

}
