<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Collection;

final class CategoryRepository
{
    public function all(): Collection
    {
        return Category::all();
    }
}
