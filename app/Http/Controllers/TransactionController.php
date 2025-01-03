<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\FetchTopUserAction;
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

        return response()->json([
            'message' => __('messages.transaction_successful'),
            'transaction' => $result,
        ]);
    }

    public function topUsers(FetchTopUserAction $fetchTopUserAction): JsonResponse
    {
        $result = $fetchTopUserAction();

        return response()->json($result);
    }
}
