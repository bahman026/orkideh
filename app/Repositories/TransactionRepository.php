<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function create($data)
    {
        return Transaction::query()->create($data);
    }

    public function update(array $data, $id)
    {
        $transaction = Transaction::query()->findOrFail($id);
        $transaction->update($data);

        return $transaction;
    }

    public function delete($id): ?bool
    {
        $transaction = Transaction::query()->findOrFail($id);

        return $transaction->delete();
    }

    public function all(): Collection
    {
        return Transaction::all();
    }

    public function find($id)
    {
        return Transaction::query()->findOrFail($id);
    }

    public static function getUserTransactions(int $userId): Builder
    {
        return Transaction::query()
            ->select(
                'transactions.id',
                'transactions.amount',
                'transactions.source_card_id',
                'transactions.destination_card_id',
                'transactions.created_at'
            )
            ->join('cards', function ($join) {
                $join->on('transactions.source_card_id', '=', 'cards.id')
                    ->orOn('transactions.destination_card_id', '=', 'cards.id');
            })
            ->join('accounts', 'accounts.id', '=', 'cards.account_id')
            ->where('accounts.user_id', $userId)
            ->orderBy('transactions.created_at', 'DESC');
    }
}
