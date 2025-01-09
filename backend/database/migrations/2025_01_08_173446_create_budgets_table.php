<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table): void {
            $table->id()->primary();
            $table->unsignedBigInteger('limit');
            $table->foreignIdFor(Category::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Theme::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->index()->constrained()->cascadeOnDelete();
            $table->unique(['user_id', 'category_id']);
            $table->unique(['user_id', 'theme_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
