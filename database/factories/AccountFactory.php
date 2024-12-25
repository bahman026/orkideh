<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\AccountNameEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()?->first() ?? User::factory(),
            'account_number' => fake()->unique()->numerify('####################'),
            'account_name' => fake()->randomElement(AccountNameEnum::cases()),
            'balance' => fake()->numberBetween(100000, 10000000),
        ];
    }
}
