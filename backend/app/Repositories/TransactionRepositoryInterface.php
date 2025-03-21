<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataObjects\TransactionDTO;
use App\DataObjects\TransactionFilterParams;
use App\Models\Transaction;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TransactionRepositoryInterface
{
    public function all(TransactionFilterParams $transactionFilterParams): LengthAwarePaginator;
    public function store(TransactionDTO $transactionDTO): bool;
    public function update(Transaction $transaction, TransactionDTO $transactionDTO): bool;
    public function delete(Transaction $transaction): bool;
    public function find(int $id): Transaction;
    public function getMonthlySpendingsForCategories(Collection $categories, int $limit = 3): Collection;
}
