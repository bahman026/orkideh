<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InsufficientBalanceException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => __('messages.insufficient_balance'),
        ], 400);
    }
}
