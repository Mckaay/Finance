<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use App\Enums\PotTransactionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StorePotTransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => [
                'bail',
                'required',
                'numeric',
                'min:-200000',
                'max:200000',
            ],
            'type' => [
                'bail',
                'required',
                Rule::enum(PotTransactionType::class),
            ],
            'pot_id' => [
                'bail',
                'required',
                'integer',
                'exists:pots,id',
            ],
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
