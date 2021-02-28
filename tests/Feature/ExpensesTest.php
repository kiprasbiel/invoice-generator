<?php

namespace Tests\Feature;

use App\Http\Livewire\Expenses\Form;
use App\Models\Expense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ExpensesTest extends TestCase
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

    // Without expenses items
    public function test_can_create_expense() {
        $someResponse = Livewire::test(Form::class)
            ->set('expenseNumber', 'SA125')
            ->set('date', Carbon::now()->sub(7, 'days')->format('Y-m-d'))
            ->set('currency', 'Eur')
            ->set('sellerName', 'Topo Centras')
            ->set('sellerAddress', 'Savanoriu pr.')
            ->set('sellerCountry', 'Lietuva')
            ->set('sellerCode', '159753789')
            ->set('sellerVAT', 'LT159753789');

        $someResponse->call('create');

        $someResponse->assertHasNoErrors();
        $this->assertTrue(Expense::whereSellerName('Topo Centras')->exists());
    }
}
