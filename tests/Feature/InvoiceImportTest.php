<?php

namespace Tests\Feature;

use App\Http\Livewire\ParseImport;
use App\Http\Livewire\Settings\InvoiceImport;
use App\Jobs\InvoiceImportProcessor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
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

    private function getCSVData(): string {
        return 'Test;Test2;Test3
Test4;Test5;Test6';
    }

    private function getFields(): array {
        return [
            "fields" => [
                10 => "price",
                5 => "created_at",
                4 => "company_name",
                2 => "company_code",
                1 => "company_vat",
                0 => "company_code",
            ]
        ];
    }

    public function testCanUploadInvoiceFile() {
        Storage::fake('invoices');

        $file = UploadedFile::fake()->createWithContent('testas.csv', $this->getCSVData());

        $fileName = Livewire::test(InvoiceImport::class)
            ->set('file', $file)
            ->set('hasHeader', false)
            ->set('type', 'Invoice')
            ->call('parse')
            ->assertEmitted('modelImport')
            ->get('fileName');

        Storage::disk('invoices')->assertExists($fileName);
    }

    public function test_activity_page_contains_parse_import_component() {
        $this->get('/activity')->assertSeeLivewire('parse-import');
    }

    public function test_activity_page_contains_invoice_import_component() {
        $this->get('/activity')->assertSeeLivewire('settings.invoice-import');
    }

    public function testModalShowsTwoFirstRows() {
        $this->assertDatabaseCount('import_data', 0);

        Storage::fake('invoices');
        $file = UploadedFile::fake()->createWithContent('testas.csv', $this->getCSVData());

        $fileName = Livewire::test(InvoiceImport::class)
            ->set('file', $file)
            ->set('hasHeader', false)
            ->set('type', 'Invoice')
            ->call('parse')
            ->get('fileName');

        $csvData = Livewire::test(ParseImport::class)
            ->call('modelImport', $fileName, 'false', 'Invoice')
            ->get('csvData');
        $this->assertCount(2, $csvData);
        $this->assertDatabaseCount('import_data', 1);
    }

    public function testJobDispatched() {
        Bus::fake();

        Livewire::test(ParseImport::class)
            ->set('fields', $this->getFields())
            ->call('startImport', 1);

        Bus::assertDispatched(InvoiceImportProcessor::class);
    }

}
