<?php

declare(strict_types=1);

namespace App\DataObjects;

use App\Enums\PotTransactionType;
use App\Http\Requests\V1\StorePotTransactionRequest;

final readonly class PotTransactionDTO
{
    public function __construct(
        public float $amount,
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
            (float) $request->validated('amount'),
            PotTransactionType::tryFrom($request->validated('type')),
            (int) $request->validated('pot_id'),
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
            'amount' => PotTransactionType::DEPOSIT === $this->type ? $this->amount : $this->amount * -1,
            'type' => $this->type->value,
            'pot_id' => $this->potId,
        ];
    }
}
