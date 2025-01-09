<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PotTransactionType;
use Database\Factories\PotTransactionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class PotTransaction extends Model
{
    /** @use HasFactory<PotTransactionFactory> */
    use HasFactory;

    protected $casts = [
        'type' => PotTransactionType::class,
    ];
}
