<?php

declare(strict_types=1);

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'transactions'], function () {
    Route::post('/transfer', [TransactionController::class, 'transfer']);
    Route::get('/top-users', [TransactionController::class, 'topUsers']);
});
