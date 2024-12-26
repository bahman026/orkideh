<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class FetchTopUserAction
{
    public function __invoke(): \Illuminate\Support\Collection
    {
        $tenMinutesAgo = Carbon::now()->subMinutes(10);
        $topUsers = User::getTopUsers()
            ->where('transactions.created_at', '>=', $tenMinutesAgo)
            ->limit(3)
            ->get();

        /** @var Collection<int, User> $topUsers */
        return $topUsers->map(function (User $user): array {
            $transactions = Transaction::getUserTransactions($user->id)
                ->limit(10)
                ->get();

            return [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'transactions' => $transactions,
            ];
        });

    }
}
