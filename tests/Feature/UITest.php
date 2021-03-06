<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UITest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testCanSeeDashboard() {
        $response = $this->get('/');

        $response->assertSee('Išrašytų sąskaitų suma');
        $response->assertSee('Sąnaudų suma');
        $response->assertSee('Mokėtini mokesčiai');

        $response->assertSee('GPM');
        $response->assertSee('VSD');
        $response->assertSee('PSD');

        $this->createInvoice();

        $response = $this->get('/');

        $response->assertSee('182');
    }

    public function testCanSeeInvoicePage() {
        $response = $this->get('/invoice');

        $response->assertSee('Data');
        $response->assertSee('Serija, numeris');
        $response->assertSee('Klientas');
        $response->assertSee('Suma');
        $response->assertSee('Neturite sukūrę sąskaitų-faktūrų');

        $this->createInvoice();

        $response = $this->get('/invoice');
        $response->assertSee('Custom Name');
    }

    public function testCanSeeNewInvoiceForm(){
        $response = $this->get('/invoice/create');

        $response->assertSee('Įmonės pavadinimas');
        $response->assertSee('Paslaugos pavadinimas');
        $response->assertSee('Pašalinti');
        $response->assertSee('Išsaugoti ir atsisiųsti');
    }

    public function testCanSeeProfile(){
        $response = $this->get('/user/profile');

        $response->assertSee('Profile Information');
        $response->assertSee('Update Password');
        $response->assertSee('Two Factor Authentication');
        $response->assertSee('Browser Sessions');
        $response->assertSee('Delete Account');
    }

    public function testCanSeeActivitySettings(){
        $response = $this->get('/activity');

        $response->assertSee('Veiklos informacija');
        $response->assertSee('Sąskaita-faktūra');
        $response->assertSee('Lengvatos ir kiti mokesčių nustatymai');
        $response->assertSee('Išlaidos');

        // Asserting default User information is prefilled
        $response->assertSee($this->user->name);
        $response->assertSee($this->user->email);
    }

    public function testCanSeeExpensesInHeader() {
        $response = $this->get('/');

        $response->assertSee('Išlaidos');
    }

    public function testCanSeeAddNewExpenseInExpensesPage() {
        $response = $this->get('/expenses');

        $response->assertSee('Pridėti išlaidas');
    }

    public function testCanSeeExpensesFrom() {
        $response = $this->get('/expenses/create');

        $response->assertSee('Serijos nr.');
        $response->assertSee('Data');
        $response->assertSee('Valiuta');
        $response->assertSee('Pavadinimas');
        $response->assertSee('Adresas');
        $response->assertSee('Šalis');
        $response->assertSee('Įmonės kodas');
        $response->assertSee('PVM kodas');
    }

    public function testCanSeeExpensesList() {
        $response = $this->get('/expenses');

        $response->assertSee('Sąskaitos numeris');
        $response->assertSee('Pardavėjas');
        $response->assertSee('Data');
        $response->assertSee('Suma');
    }

    private function createInvoice() {
        return Invoice::factory()
            ->hasInvoiceItems(1, [
                'price' => 182,
                'quantity' => 1
            ])
            ->create([
                'user_id' => $this->user->id,
                'company_name' => 'Custom Name',
            ]);
    }

    protected function tearDown(): void {
        parent::tearDown();

        $this->user = NULL;
    }
}
