<?php

namespace Tests\Feature;

use App\Http\Livewire\Invoice\InvoiceInfo;
use App\Http\Livewire\InvoiceForm;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class InvoiceGenTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $user;
    protected $invoice;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    protected function get_form_data(){
        return $array = [
            'companyName' => $this->faker->name . ', UAB',
            'companyCode' => $this->faker->randomNumber(9),
            'companyVat' => 'LT' . $this->faker->randomNumber(9),
            'companyAddress' => $this->faker->address,
        ];
    }

    protected function create_invoice_and_invoice_item(array $newInvoiceData = [], array $newItemData = []){
        $invoiceData = [
            'company_name' => 'Company, UAB',
            'user_id' => $this->user->id,
        ];

        $itemData = [
            'name' => 'Random item',
            'price' => 18,
            'quantity' => 14,
            'unit' => '.khd',
        ];

        $invoiceData = array_merge($invoiceData, $newInvoiceData);
        $itemData = array_merge($itemData, $newItemData);

        return $this->invoice = Invoice::factory()
            ->hasItems(1, $itemData)
            ->create($invoiceData);
    }

    public function test_can_open_invoice_create_page(){
        $response = $this->get('/invoice/create');
        $response->assertOk();
    }

    public function test_can_create_invoice(){
        $someResponse = Livewire::test(InvoiceForm::class)
            ->set('companyName', 'UAB Test')
            ->set('companyCode', $this->faker->randomNumber(9))
            ->set('companyVat', 'LT' . $this->faker->randomNumber(9))
            ->set('companyAddress', $this->faker->streetAddress)
            ->set('payBy', Carbon::now()->add(7, 'days')->format('Y-m-d'))
            ->set('productList', [
                ['product_name' => $this->faker->name,
                'product_price' => $this->faker->randomNumber(2),
                'product_pcs' => $this->faker->randomNumber(2),
                'pcs_type' => '.' . Str::random(3),]
            ]);
        $someResponse->call('create');

        $someResponse->assertHasNoErrors();
        $this->assertTrue(Invoice::whereCompanyName('UAB Test')->exists());
    }

    public function test_can_see_message_when_no_invoices_are_created(){
        $response = $this->get('/invoice');
        $response->assertSee('Neturite sukūrę sąskaitų-faktūrų');
    }

    public function test_can_see_created_invoice_in_invoice_table(){
        $this->create_invoice_and_invoice_item();

        $response = $this->get('/invoice');
        $response->assertDontSee('Neturite sukūrę sąskaitų-faktūrų');

        $response->assertSee('Company, UAB');
        $response->assertSee('252');
    }

    public function test_can_see_invoice_items_in_expanded_invoice_table(){
        $this->create_invoice_and_invoice_item();

        Livewire::test(InvoiceInfo::class, ['invoice' => $this->invoice])
            ->call('getInvoice', true)
            ->assertSee('Random item')
            ->assertSee('18')
            ->assertSee('14');
    }

    public function test_delete_button_emits_delete_event_and_removes_deleted_invoice(){
        $this->create_invoice_and_invoice_item();

        Livewire::test(InvoiceInfo::class, ['invoice' => $this->invoice])
            ->call('delete')
            ->assertEmitted('delete-' . $this->invoice->id)
            ->assertDontSee('Random item');
    }

    public function test_can_delete_invoice_and_invoice_items() {
        $this->create_invoice_and_invoice_item();

        $this->invoice->delete();
        $this->assertFalse(Invoice::whereCompanyName('Company, UAB')->exists());
        $this->assertFalse(Item::whereName('Random item')->exists());
    }

    public function test_invoice_number_increments() {
        $response = $this->create_invoice_and_invoice_item();
        $this->assertEquals(1, $response->sf_number);
        $response = $this->create_invoice_and_invoice_item();
        $this->assertEquals(2, $response->sf_number);
    }

    protected function tearDown(): void {
        parent::tearDown();

        $this->user = NULL;
    }

}
