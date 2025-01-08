<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Transaction */
final class TransactionResource extends JsonResource
{
    /**
     * Transform Model Resource To Array.
     *
     * @param Request $request
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'amount' => $this->amount,
            'date' => Carbon::parse($this->date)->format('d M Y'),
            'category' => $this->whenLoaded('category', fn() => new CategoryResource($this->category)),
        ];
    }
}
