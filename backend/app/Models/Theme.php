<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ThemeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Theme extends Model
{
    /** @use HasFactory<ThemeFactory> */
    use HasFactory;
}
