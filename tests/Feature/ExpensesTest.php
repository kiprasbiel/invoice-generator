<?php

namespace Tests\Feature;

use App\Http\Livewire\Expenses\Form;
use App\Http\Livewire\Expenses\RowList;
use App\Models\Expense;
use App\Models\Item;
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
    protected Expense $expense;

    protected function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    protected function tearDown(): void {
        parent::tearDown();

        $this->user = NULL;
    }

    protected function createNewExpenseWithLivewire() {
        $someResponse = Livewire::test(Form::class)
            ->set('expenseNumber', 'SA125')
            ->set('date', Carbon::now()->sub(7, 'days')->format('Y-m-d'))
            ->set('currency', 'Eur')
            ->set('sellerName', 'Topo Centras')
            ->set('sellerAddress', 'Savanoriu pr.')
            ->set('sellerCode', '159753789')
            ->set('sellerVAT', 'LT159753789')
            ->set('productList', [
                ['product_name' => 'Produktas',
                    'product_price' => 52,
                    'product_pcs' => 3,
                    'pcs_type' => '.vnt',]
            ]);

        $someResponse->call('create');
        return $someResponse;
    }

    protected function createNewExpenseAndItem() {
        $this->expense = Expense::factory()->hasItems(1, [
            'name' => 'Random item',
            'price' => 18,
            'quantity' => 14,
            'unit' => '.khd',
        ])->create([
            'user_id' => $this->user->id,
        ]);
    }

    // Without expenses items
    public function test_can_create_expense() {
        $someResponse = $this->createNewExpenseWithLivewire();

        $someResponse->assertHasNoErrors();
        $this->assertTrue(Expense::whereSellerName('Topo Centras')->exists());
        $this->assertTrue(Item::whereName('Produktas')->exists());
    }

    public function testIfExpensesTableIsEmptyThenExplainWhy() {
        $response = $this->get('/expenses');

        $response->assertSee('Neturite sukūrę išlaidų');
    }

    public function testCanSeeCreatedExpensesInTable() {
        // TODO: Papildyti
        $this->createNewExpenseWithLivewire();

        $response = $this->get('/expenses');
        $response->assertDontSee('Neturite sukūrę išlaidų');

        $response->assertSee('SA125');
        $response->assertSee('Topo Centras');
    }

    public function testCanSeeExpenseItemInExpandedExpensesTable() {
        $this->createNewExpenseAndItem();

        Livewire::test(RowList::class, ['expense' => $this->expense])
            ->call('getExpense', true)
            ->assertSee('Random item')
            ->assertSee('18')
            ->assertSee('14');
    }

    public function testCanSeeCRUDInExpandedExpensesTable() {
        $this->createNewExpenseAndItem();

        Livewire::test(RowList::class, ['expense' => $this->expense])
            ->call('getExpense', true)
            ->assertSee('Redaguoti')
            ->assertSee('Ištrinti');
    }
}
