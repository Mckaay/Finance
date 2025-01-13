<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use App\Enums\SortingOptions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

final class IndexTransactionRequest extends FormRequest
{
    /**
     * Define array of rules to validate the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'max:50',
            'categoryId' => 'integer',
            'order' => [new Enum(SortingOptions::class)],
        ];
    }
}
