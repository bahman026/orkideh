<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\TransactionEvent;
use App\Mail\TransactionNotification;
use App\Models\Card;
use Illuminate\Support\Facades\Mail;

class SendTransactionEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionEvent $event)
    {
        $transaction = $event->transaction;

        $sourceCard = Card::query()->find($transaction->source_card_id);
        Mail::to($sourceCard->account->user->email) //@phpstan-ignore-line
            ->queue(new TransactionNotification($transaction, $sourceCard, 'decrease'));

        $destinationCard = Card::query()->find($transaction->destination_card_id);
        Mail::to($destinationCard->account->user->email) //@phpstan-ignore-line
            ->queue(new TransactionNotification($transaction, $destinationCard, 'increase'));
    }
}
