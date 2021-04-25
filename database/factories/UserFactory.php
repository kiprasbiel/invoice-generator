<?php

namespace Database\Factories;

use App\Models\Meta;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    public function configure()
    {
        // Adding user Settings
        return $this->afterCreating(function (User $user) {
            Meta::factory()->create([
                'name' => 'userActivitySettings',
                'value' => '{"full_name":"' . $user->name .  '","iv_code":null,"personal_code":null,"address":null,"phone":null,"email":"' . $user->email . '","additional_info":null,"bank_name":null,"bank_account_num":null,"vat":null}',
                'metable_id' => $user->id,
            ]);
            Meta::factory()->create([
                'name' => 'sfNumberSettings',
                'value' => '{"sf_code":"SF","sf_number":"1"}',
                'metable_id' => $user->id,
            ]);
            Meta::factory()->create([
                'name' => 'privilegesSettings',
                'value' => '{"isStudent":null,"isFirstTimer":null,"isPensioner":null,"additionalPension":"pens0","isFreeMarketActivity":null}',
                'metable_id' => $user->id,
            ]);
            Meta::factory()->create([
                'name' => 'mailSettings',
                'value' => '{"sender":null,"headline":null,"messageBody":null}',
                'metable_id' => $user->id,
            ]);
        });
    }
}
