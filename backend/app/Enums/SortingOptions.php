<?php

declare(strict_types=1);

namespace App\Enums;

enum SortingOptions: string
{
    case LATEST = 'latest';
    case OLDEST = 'oldest';
    case ATOZ = 'atoz';
    case ZTOA = 'ztoa';
    case HIGHEST = 'highest';
    case LOWEST = 'lowest';
}
