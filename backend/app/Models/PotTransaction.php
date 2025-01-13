<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PotTransactionType;
use Database\Factories\PotTransactionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class PotTransaction extends Model
{
    /** @use HasFactory<PotTransactionFactory> */
    use HasFactory;

    protected $casts = [
        'type' => PotTransactionType::class,
    ];

    public function pot(): BelongsTo
    {
        return $this->belongsTo(Pot::class);
    }
}
