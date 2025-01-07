<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\ThemeResource;
use App\Repositories\ThemeRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class ThemeController
{
    public function index(ThemeRepository $themeRepository): AnonymousResourceCollection
    {
        return ThemeResource::collection($themeRepository->all());
    }
}
