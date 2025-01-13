<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use App\Models\Pot;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

final class UpdatePotRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'bail',
                'required',
                'string',
                'unique:pots,name',
                'min:3',
                'max: 60',
            ],
            'target' => [
                'bail',
                'required',
                'integer',
                'min: 0',
                'max:200000',
            ],
            'theme_id' => [
                'bail',
                'required',
                'integer',
                'exists:themes,id',
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($this->theme_id === $value) {
                        return;
                    }

                    $exists = Pot::with('theme')->where('theme_id', $value)
                        ->exists();
                    if ($exists) {
                        $fail("The pot with this {$attribute} already exists.");
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
