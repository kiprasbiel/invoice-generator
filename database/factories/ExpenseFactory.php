<?php

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'seller_name' => $this->faker->name,
            'seller_code' => $this->faker->randomNumber(8),
            'seller_address' => $this->faker->address,
            'seller_vat' => 'LT' . $this->faker->randomNumber(8),
            'number' => 'SUB' . $this->faker->randomNumber(8),
            'date' => $this->faker->dateTime(),
            'currency' => $this->faker->currencyCode,
        ];
    }
}
