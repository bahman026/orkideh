<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'source_card_id',
        'destination_card_id',
        'amount',
    ];

    public function sourceCard(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'source_card_id');
    }

    public function destinationCard(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'destination_card_id');
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
