<?php

declare(strict_types=1);

namespace App\Models;

use App\Scopes\UserScope;
use Database\Factories\BudgetFactory;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * @mixin Budget
 * @property Collection $transactions Transactions related to the budget (negative amounts within the month).
 * @property string $monthlySpendings Current  month spendings in this category.
 */
#[ScopedBy(UserScope::class)]
final class Budget extends Model
{
    /** @use HasFactory<BudgetFactory> */
    use HasFactory;

    public function casts(): array
    {
        return [
            'limit' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }
}
