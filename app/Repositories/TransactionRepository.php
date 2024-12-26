<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
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
}
