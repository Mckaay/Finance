<?php

declare(strict_types=1);

namespace App\DataObjects;

use App\Http\Requests\V1\StoreTransactionRequest;
use Carbon\Carbon;

final readonly class TransactionDTO
{
    public function __construct(
        public string $name,
        public string $amount,
        public Carbon $date,
        public int $categoryId,
    ) {}

    /**
     * Create a TransactionDTO from a store request.
     *
     * @param StoreTransactionRequest $request
     * @return self
     */
    public static function fromRequest(StoreTransactionRequest $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('amount'),
            Carbon::parse($request->input('date')),
            (int) $request->input('category_id'),
        );
    }

    /**
     * Convert the TransactionDTO to an associative array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'amount' => $this->amount,
            'date' => $this->date->format('Y-m-d'),
            'category_id' => $this->categoryId,
        ];
    }
}
