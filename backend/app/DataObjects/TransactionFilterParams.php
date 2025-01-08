<?php

declare(strict_types=1);

namespace App\DataObjects;

use App\Enums\SortingOptions;
use App\Http\Requests\V1\IndexTransactionRequest;

final readonly class TransactionFilterParams
{
    public function __construct(
        public string $name,
        public SortingOptions $order,
        public int $categoryId,
    ) {}

    /**
     * Creates a new instance from the request.
     *
     * @param IndexTransactionRequest $request
     * @return self
     */
    public static function fromRequest(IndexTransactionRequest $request): TransactionFilterParams
    {
        return new self(
            $request->get('name') ?? '',
            SortingOptions::from($request->get('order') ?? 'latest'),
            $request->get('categoryId') ? (int) $request->get('categoryId') : 0,
        );
    }

    /**
     * Returns an array of sorting definitions keyed by SortingOptions.
     *
     * @return array
     */
    public function getSortingColumnAndOrder(): array
    {
        return match ($this->order) {
            SortingOptions::LATEST => ['date', 'desc'],
            SortingOptions::OLDEST => ['date', 'asc'],
            SortingOptions::ATOZ => ['name', 'asc'],
            SortingOptions::ZTOA => ['name', 'desc'],
            SortingOptions::HIGHEST => ['amount', 'desc'],
            SortingOptions::LOWEST => ['amount', 'asc'],
        };
    }
}
