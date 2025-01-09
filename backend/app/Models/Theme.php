<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ThemeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Theme extends Model
{
    /** @use HasFactory<ThemeFactory> */
    use HasFactory;

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }
}
