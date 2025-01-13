<?php

declare(strict_types=1);

namespace App\DataObjects;

use App\Enums\PotTransactionType;
use App\Http\Requests\V1\StorePotTransactionRequest;

final readonly class PotTransactionDTO
{
    public function __construct(
        public string $amount,
        public PotTransactionType $type,
        public int $potId,
    ) {}

    /**
     * Create a PotTransactionDTO from a store request.
     *
     * @param StorePotTransactionRequest $request
     * @return self
     */
    public static function fromRequest(StorePotTransactionRequest $request): self
    {
        return new self(
            $request->input('amount'),
            PotTransactionType::tryFrom($request->input('type')),
            (int) $request->input('pot_id'),
        );
    }

    /**
     * Convert the PotTransactionDTO to an associative array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'type' => $this->type->value,
            'pot_id' => $this->potId,
        ];
    }
}
