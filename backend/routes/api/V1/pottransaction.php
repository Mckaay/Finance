<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\PotTransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('pottransactions')->name('pottransactions:')->group(function (): void {
    Route::post('/', [PotTransactionController::class,'store'])->name('store');
});
