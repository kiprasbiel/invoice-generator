<?php

namespace Tests\Feature;

use App\Http\Livewire\Invoice\InvoiceSendModal;
use App\Mail\InvoiceMail;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class MailTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public ?User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    protected function tearDown(): void {
        parent::tearDown();

        $this->user = NULL;
    }

    protected function getData(): array {
        return [
            'headline' => 'Labas vakaras',
            'messageBody' => 'Kaip gyvenate?',
            'username' => 'Kipras Bielinskas',
        ];
    }

    protected function getInvoice(array $newInvoiceData = [], array $newItemData = []) {
        $invoiceData = [
            'user_id' => $this->user->id
        ];

        $itemData = [
            'name' => 'Random item',
            'price' => 18,
            'quantity' => 14,
            'unit' => '.khd',
        ];

        $invoiceData = array_merge($invoiceData, $newInvoiceData);
        $itemData = array_merge($itemData, $newItemData);

        return Invoice::factory()
            ->hasItems(1, $itemData)
            ->create($invoiceData);
    }

    public function test_mailable_content()
    {
        $data = $this->getData();
        $invoice = $this->getInvoice();
        $mailable = new InvoiceMail($data, $invoice);

        $mailable->assertSeeInHtml($data['headline']);
        $mailable->assertSeeInHtml($data['messageBody']);
        $mailable->assertSeeInHtml($data['username']);
    }

    public function testMailSent() {
        Mail::fake();
        $invoice = $this->getInvoice();
        $data = $this->getData();

        Livewire::test(InvoiceSendModal::class)
            ->call('openModal', $invoice->toArray())
            ->set('receiver', 'info@info.dev')
            ->set('headline', $data['headline'])
            ->set('messageBody', $data['messageBody'])
            ->call('send');

        Mail::assertSent(InvoiceMail::class);
    }
}
