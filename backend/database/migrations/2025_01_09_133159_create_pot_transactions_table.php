<?php

declare(strict_types=1);

use App\Models\Pot;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pot_transactions', function (Blueprint $table): void {
            $table->id()->primary();
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['deposit', 'withdraw'])->default('deposit');
            $table->foreignIdFor(Pot::class)->index()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pot_transactions');
    }
};
