<?php

namespace Database\Factories;

use App\Models\Meta;
use Illuminate\Database\Eloquent\Factories\Factory;

class MetaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'userActivitySettings',
            'value' => '{"full_name":"Test","iv_code":null,"personal_code":null,"address":null,"phone":null,"email":"test@test.com","additional_info":null,"bank_name":null,"bank_account_num":null,"vat":null}',
            'metable_id' => 1,
            'metable_type' => 'App\Models\User',
        ];
    }
}
