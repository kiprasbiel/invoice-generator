<?php

namespace Tests\Feature;

use App\Http\Livewire\InvoiceForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class InvoiceGenTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function login() {
        $response = $this->actingAs(User::factory()->create());
        $response->assertAuthenticated();
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
        $this->login();

        $response = $this->get('/invoice/create');
        $response->assertOk();
    }

    public function test_can_create_invoice(){
        $this->withoutExceptionHandling();
        $this->login();

        Livewire::test(InvoiceForm::class, $this->get_form_data())
            ->set('productList.0.product_name', $this->faker->name)
            ->set('productList.0.product_price', $this->faker->numberBetween(1, 10000))
            ->set('productList.0.product_pcs', $this->faker->numberBetween(1, 100))
            ->set('productList.0.pcs_type', $this->faker->lexify('???') . '.')
            ->call('submit')
            ->assertHasNoErrors();
    }

}
