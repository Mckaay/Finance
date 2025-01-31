<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PotTransactionType;
use App\Observers\PotTransactionObserver;
use App\Scopes\UserScope;
use Database\Factories\PotTransactionFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy(UserScope::class)]
#[ObservedBy([PotTransactionObserver::class])]
final class PotTransaction extends Model
{
    /** @use HasFactory<PotTransactionFactory> */
    use HasFactory;

    protected $casts = [
        'type' => PotTransactionType::class,
    ];

    public function pot(): BelongsTo
    {
        return $this->belongsTo(Pot::class);
    }
}
