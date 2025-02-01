<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\GlobalObserver;
use App\Scopes\UserScope;
use Database\Factories\BudgetFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
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
#[ObservedBy([GlobalObserver::class])]
final class Budget extends Model
{
    /** @use HasFactory<BudgetFactory> */
    use HasFactory;

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
