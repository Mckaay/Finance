<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Pot;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Pot */
final class PotResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'target' => (string) $this->target,
            'theme' => new ThemeResource($this->whenLoaded('theme')),
            'balance' => (string) round(($this->depositSum + $this->withdrawSum), 2), // @phpstan-ignore-line
        ];
    }
}
