<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Card::factory()->count(30)->create();
    }
}
