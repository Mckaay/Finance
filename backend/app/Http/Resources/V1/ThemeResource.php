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
        $disabled = false;

        if (isset($this->budgets_count)) {
            $disabled = $this->budgets_count > 0;
        }

        if (isset($this->pots_count)) {
            $disabled = $this->pots_count > 0;
        }

        return [
            'value' => $this->id,
            'label' => $this->name,
            'color' => $this->color,
            'disabled' => $disabled,
        ];
    }
}
