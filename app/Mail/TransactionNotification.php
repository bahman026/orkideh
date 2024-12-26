<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Mail\Mailable;

class TransactionNotification extends Mailable
{
    public $transaction;

    public $card;

    public $type;

    public function __construct(Transaction $transaction, Card $card, string $type)
    {
        $this->transaction = $transaction;
        $this->card = $card;
        $this->type = $type;
    }

    public function build(): TransactionNotification
    {
        $subject = $this->type === 'decrease'
            ? __('email.your_account_has_been_debited')
            : __('email.your_account_has_been_credited');

        return $this->view('emails.transaction')
            ->subject($subject)
            ->with([
                'transaction' => $this->transaction,
                'card' => $this->card,
                'type' => $this->type,
            ]);
    }
}
