<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->name('categories:')->group(function (): void {
    Route::get('/', [CategoryController::class,'index'])->name('index');
});
