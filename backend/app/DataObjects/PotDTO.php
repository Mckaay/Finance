<?php

declare(strict_types=1);

namespace App\DataObjects;

use Illuminate\Foundation\Http\FormRequest;

final readonly class PotDTO
{
    public function __construct(
        public string $name,
        public string $target,
        public int $themeId,
    ) {}

    /**
     * Create a PotDTO from a store request.
     *
     * @param FormRequest $request
     * @return self
     */
    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('target'),
            (int) $request->input('theme_id'),
        );
    }

    /**
     * Convert the PotDTO to an associative array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'target' => $this->target,
            'theme_id' => $this->themeId,
        ];
    }
}
