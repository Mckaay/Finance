<?php

declare(strict_types=1);

namespace App\DataObjects;

use Illuminate\Foundation\Http\FormRequest;

final readonly class BudgetDTO
{
    public function __construct(
        public mixed $limit,
        public int $categoryId,
        public int $themeId,
    ) {}

    /**
     * Create a BudgetDTO from a store request.
     *
     * @param FormRequest $request
     * @return self
     */
    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            $request->input('limit'),
            (int) $request->input('category_id'),
            (int) $request->input('theme_id'),
        );
    }

    /**
     * Convert the BudgetDTO to an associative array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'limit' => $this->limit,
            'category_id' => $this->categoryId,
            'theme_id' => $this->themeId,
        ];
    }
}
