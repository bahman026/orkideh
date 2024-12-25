<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'account_id' => Account::query()->inRandomOrder()->first() ?? Account::factory(),
            'card_number' => function ($attributes) {
                $account_name = Account::query()->find($attributes['account_id'])->account_name;
                $numbers = $account_name->numbers();

                return Arr::random($numbers) . fake()->numerify('##-####-####');
            },
        ];
    }
}
