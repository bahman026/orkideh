<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\TransactionDTO;
use App\Exceptions\InsufficientBalanceException;
use App\Http\Requests\TransferRequest;
use App\Jobs\TransactionEmailJob;
use App\Models\Card;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class TransferAction
{
    /**
     * @throws Exception
     * @throws Throwable
     */
    public function __invoke(TransferRequest $request)
    {

        $sourceCard = Card::query()->where('card_number', $request->source_card_id)->first();
        $destinationCard = Card::query()->where('card_number', $request->destination_card_id)->first();
        $this->checkSufficientBalance($sourceCard, $request);

        try {
            DB::beginTransaction();

            $sourceCard->account->decrement('balance', $request->amount);
            $destinationCard->account->increment('balance', $request->amount);

            $transactionDto = new TransactionDTO(
                $sourceCard->id,
                $destinationCard->id,
                (int) $request->amount,
            );

            $transaction = Transaction::query()->create($transactionDto->toArray());

            TransactionEmailJob::dispatch($transaction);

            DB::commit();

            return $transaction;
        } catch (Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * @throws InsufficientBalanceException
     */
    private function checkSufficientBalance($sourceCard, $request): void
    {
        if ($sourceCard->account->balance < $request->amount) {
            throw new InsufficientBalanceException;
        }
    }
}
