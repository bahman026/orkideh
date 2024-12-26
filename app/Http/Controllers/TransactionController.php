<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\TransferAction;
use App\Http\Requests\TransferRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

class TransactionController extends Controller
{
    /**
     * @throws Throwable
     */
    public function transfer(TransferRequest $request, TransferAction $transferAction): JsonResponse
    {
        $result = $transferAction($request);

        return response()->json(['message' => 'تراکنش با موفقیت انجام شد.', 'transaction' => $result]);
    }
}
