<?php

namespace Tests\Feature;

use App\Http\Livewire\InvoiceForm;
use App\Models\Invoice;
use App\Models\User;
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

    public function test_can_see_created_invoice_in_invoice_table(){
        $response = $this->get('/invoice');
        $response->assertSee('Neturite sukūrę sąskaitų-faktūrų');

        Invoice::factory()->hasInvoiceItems(1, [
            'name' => 'Item',
            'price' => 108,
            'quantity' => 1,
        ])->create([
            'company_name' => 'Company, UAB',
            'user_id' => $this->user->id,
        ]);
        $response = $this->get('/invoice');
        $response->assertDontSee('Neturite sukūrę sąskaitų-faktūrų');

        $response->assertSee('Company, UAB');
        $response->assertSee('108');
    }

    protected function tearDown(): void {
        parent::tearDown();

        $this->user = NULL;
    }

}
