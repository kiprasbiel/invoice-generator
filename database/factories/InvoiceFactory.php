<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_name' => $this->faker->name,
            'company_code' => $this->faker->randomNumber(8),
            'company_address' => $this->faker->address,
            'company_vat' => 'LT' . $this->faker->randomNumber(8),
        ];
    }
}
