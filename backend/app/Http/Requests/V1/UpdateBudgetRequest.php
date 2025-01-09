<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use App\Models\Budget;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateBudgetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'limit' => [
                'bail',
                'required',
                'integer',
                'min: 30',
                'max: 2000000',
            ],
            'category_id' => [
                'bail',
                'required',
                'integer',
                'exists:categories,id',
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($value === $this->category_id) {
                        return;
                    }

                    $exists = Budget::with('category')->where('category_id', $value)
                        ->exists();
                    if ($exists) {
                        $fail("The budget with this {$attribute} already exists.");
                    }
                },
            ],
            'theme_id' => [
                'bail',
                'required',
                'integer',
                'exists:themes,id',
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($value === $this->theme_id) {
                        return;
                    }

                    $exists = Budget::with('theme')->where('theme_id', $value)->exists();
                    if ($exists) {
                        $fail("The budget with this {$attribute} already exists.");
                    }
                },
            ],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
