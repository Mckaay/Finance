<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Enums\CacheKey;
use App\Http\Resources\V1\CategoryResource;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

final class CategoryController
{
    public function index(CategoryRepository $categoryRepository): AnonymousResourceCollection
    {
        $categories = Cache::rememberForever(CacheKey::CATEGORIES->value, fn() => CategoryResource::collection($categoryRepository->all()));

        return CategoryResource::collection($categories);
    }
}
