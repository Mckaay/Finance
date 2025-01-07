<?php

declare(strict_types=1);

namespace App\Enums;

enum CacheKey: string
{
    case CATEGORIES = 'categories';
    case THEMES = 'themes';
}
