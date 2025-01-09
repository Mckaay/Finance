<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Budget */
final class BudgetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'limit' => $this->limit,
            'monthlySpendings' => $this->monthlySpendings,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'theme' => new ThemeResource($this->whenLoaded('theme')),
            'transactions' => TransactionResource::collection($this->transactions ?? []),
        ];
    }
}
