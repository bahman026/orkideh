<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function create($data)
    {
        return User::query()->create($data);
    }

    public function update(array $data, $id)
    {
        $user = User::query()->findOrFail($id);
        $user->update($data);

        return $user;
    }

    public function delete($id): ?bool
    {
        $user = User::query()->findOrFail($id);

        return $user->delete();
    }

    public function all(): Collection
    {
        return User::all();
    }

    public function find($id)
    {
        return User::query()->findOrFail($id);
    }

    public function getTopUsers(): Builder
    {
        return User::query()
            ->select('users.id', 'users.name')
            ->join('accounts', 'accounts.user_id', '=', 'users.id')
            ->join('cards', 'cards.account_id', '=', 'accounts.id')
            ->join('transactions', function ($join) {
                $join->on('transactions.source_card_id', '=', 'cards.id')
                    ->orOn('transactions.destination_card_id', '=', 'cards.id');
            })
            ->groupBy('users.id')
            ->orderByRaw('COUNT(transactions.id) DESC');
    }
}
