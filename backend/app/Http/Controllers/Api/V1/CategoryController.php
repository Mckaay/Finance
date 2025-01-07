<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\CategoryResource;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class CategoryController
{
    public function index(CategoryRepository $categoryRepository): AnonymousResourceCollection
    {
        return CategoryResource::collection($categoryRepository->all());
    }
}
