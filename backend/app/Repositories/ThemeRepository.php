<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Theme;
use Illuminate\Support\Collection;

final class ThemeRepository
{
    public static function getAvailableThemesForBudget(): Collection
    {
        return Theme::query()->withCount('budgets')->get();
    }

    public static function getAvailableThemesForPots(): Collection
    {
        return Theme::query()->withCount('pots')->get();
    }
    public function all(): Collection
    {
        return Theme::all();
    }
}
