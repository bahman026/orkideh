<?php

declare(strict_types=1);

namespace Feature\Transactions\Actions;

use App\Models\Account;
use App\Models\Card;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use const _PHPStan_4afa27bf8\__;

class TransferActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_transfer_successful(): void
    {
        $sourceUser = User::factory()->create();
        $destinationUser = User::factory()->create();

        $sourceAccount = Account::factory()->create(['user_id' => $sourceUser->id, 'balance' => 10000]);
        $destinationAccount = Account::factory()->create(['user_id' => $destinationUser->id, 'balance' => 5000]);

        $sourceCard = Card::factory()->create(['account_id' => $sourceAccount->id, 'card_number' => '6221-0622-3333-4444']);
        $destinationCard = Card::factory()->create(['account_id' => $destinationAccount->id, 'card_number' => '6391-9466-7777-8888']);

        $payload = [
            'source_card_id' => '6221-0622-3333-4444',
            'destination_card_id' => '6391-9466-7777-8888',
            'amount' => 3000,
        ];

        $response = $this->postJson('/api/transactions/transfer', $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('accounts', [
            'id' => $sourceAccount->id,
            'balance' => 7000,
        ]);

        $this->assertDatabaseHas('accounts', [
            'id' => $destinationAccount->id,
            'balance' => 8000,
        ]);

        $this->assertDatabaseHas('transactions', [
            'source_card_id' => $sourceCard->id,
            'destination_card_id' => $destinationCard->id,
            'amount' => 3000,
        ]);
    }

    public function test_transfer_fails_due_to_insufficient_balance(): void
    {
        $sourceUser = User::factory()->create();
        $destinationUser = User::factory()->create();

        $sourceAccount = Account::factory()->create(['user_id' => $sourceUser->id, 'balance' => 2000]);
        $destinationAccount = Account::factory()->create(['user_id' => $destinationUser->id, 'balance' => 5000]);

        Card::factory()->create(['account_id' => $sourceAccount->id, 'card_number' => '6221-0622-3333-4444']);
        Card::factory()->create(['account_id' => $destinationAccount->id, 'card_number' => '6391-9466-7777-8888']);

        $payload = [
            'source_card_id' => '6221-0622-3333-4444',
            'destination_card_id' => '6391-9466-7777-8888',
            'amount' => 3000,
        ];

        $response = $this->postJson('/api/transactions/transfer', $payload);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => __('messages.insufficient_balance'),
        ]);

        $this->assertDatabaseHas('accounts', [
            'id' => $sourceAccount->id,
            'balance' => 2000,
        ]);

        $this->assertDatabaseHas('accounts', [
            'id' => $destinationAccount->id,
            'balance' => 5000,
        ]);
    }

    public function test_transfer_fails_due_to_invalid_cards(): void
    {
        $payload = [
            'source_card_id' => 'invalid_card_number',
            'destination_card_id' => 'another_invalid_card_number',
            'amount' => 3000,
        ];

        $response = $this->postJson('/api/transactions/transfer', $payload);

        $response->assertStatus(422);
    }
}
