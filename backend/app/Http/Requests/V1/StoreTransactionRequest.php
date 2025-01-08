<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

final class StoreTransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'bail',
                'required',
                'string',
                'min:3',
                'max:50',
            ],

            'amount' => [
                'bail',
                'required',
                'numeric',
                'min:-200000',
                'max:200000',
            ],

            'category_id' => [
                'bail',
                'required',
                'integer',
                'exists:categories,id',
            ],

            'date' => [
                'bail',
                'required',
                'date',
                'date_format:Y-m-d',
                'before_or_equal:today',
            ],
        ];
    }
}
