<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('transactions')->name('transactions:')->group(function (): void {
    Route::get('/', [TransactionController::class,'index'])->name('index');
    Route::post('/', [TransactionController::class,'store'])->name('store');
    Route::put('{transaction}', [TransactionController::class,'update'])->name('update');
    Route::delete('{transaction}', [TransactionController::class,'delete'])->name('delete');
});
