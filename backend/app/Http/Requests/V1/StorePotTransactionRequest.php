<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use App\Enums\PotTransactionType;
use App\Models\PotTransaction;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StorePotTransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'pot_id' => [
                'bail',
                'required',
                'integer',
                'exists:pots,id',
            ],
            'type' => [
                'bail',
                'required',
                Rule::enum(PotTransactionType::class),
            ],
            'amount' => [
                'bail',
                'required',
                'numeric',
                'min: 1',
                'max:200000',
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($this->validated('type') === PotTransactionType::DEPOSIT->value) {
                        return;
                    }

                    $balance = PotTransaction::query()
                        ->where('pot_id', $this->validated('pot_id'))
                        ->sum('amount');

                    if (($balance - (float) $this->validated('amount')) < 0) {
                        $fail("You can't withdraw more then you deposited");
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
