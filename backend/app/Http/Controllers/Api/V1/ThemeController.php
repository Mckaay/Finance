<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Enums\CacheKey;
use App\Http\Resources\V1\ThemeResource;
use App\Repositories\ThemeRepository;
use Cache;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class ThemeController
{
    public function index(ThemeRepository $themeRepository): AnonymousResourceCollection
    {
        $themes = Cache::rememberForever(CacheKey::THEMES->value, fn() => $themeRepository->all());

        return ThemeResource::collection($themes);
    }
}
