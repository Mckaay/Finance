<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Theme;
use Illuminate\Support\Collection;

final class ThemeRepository
{
    public function all(): Collection
    {
        return Theme::all();
    }
}
