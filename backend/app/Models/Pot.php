<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\PotObserver;
use App\Scopes\UserScope;
use Database\Factories\PotFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy(UserScope::class)]
#[ObservedBy([PotObserver::class])]
final class Pot extends Model
{
    /** @use HasFactory<PotFactory> */
    use HasFactory;


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function pottransactions(): HasMany
    {
        return $this->hasMany(PotTransaction::class);
    }
}
