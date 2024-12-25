<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'source_card_id' => Card::query()->inRandomOrder()->first()?->source_card_id ?? Card::factory(),
            'destination_card_id' => Card::query()->inRandomOrder()->first()?->destination_card_id ?? Card::factory(),
            'amount' => fake()->numberBetween(1000, 10000),
        ];
    }
}
