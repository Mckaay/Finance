<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\BudgetController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('budgets')->name('budgets:')->group(function (): void {
    Route::get('/', [BudgetController::class,'index'])->name('index');
    Route::get('/options', [BudgetController::class,'getAvailableOptions'])->name('options');
    Route::get('/{budget}', [BudgetController::class,'show'])->name('show');
    Route::post('/', [BudgetController::class,'store'])->name('store');
    Route::put('{budget}', [BudgetController::class,'update'])->name('update');
    Route::delete('{budget}', [BudgetController::class,'delete'])->name('delete');
});
