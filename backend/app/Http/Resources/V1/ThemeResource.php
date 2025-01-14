<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Theme */
final class ThemeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'color' => $this->color,
            'disabled' => isset($this->budgets_count) ? $this->budgets_count > 0 : false,
        ];
    }
}
