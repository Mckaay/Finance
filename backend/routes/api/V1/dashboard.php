<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('dashboard')->name('dashboard')->group(function (): void {
    Route::get('/', [DashboardController::class,'index'])->name(':index');
});
