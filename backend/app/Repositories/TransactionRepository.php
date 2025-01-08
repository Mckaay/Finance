<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataObjects\TransactionDTO;
use App\DataObjects\TransactionFilterParams;
use App\Models\Transaction;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Repository for managing transactions.
 */
final class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * Retrieve all transactions based on filter parameters.
     *
     * @param TransactionFilterParams $transactionFilterParams
     * @return Collection
     */
    public function all(TransactionFilterParams $transactionFilterParams): Collection
    {
        $query = Transaction::query()->with('category');

        if ('' !== $transactionFilterParams->name) {
            $query->where('name', 'like', '%' . $transactionFilterParams->name . '%');
        }

        if (0 !== $transactionFilterParams->categoryId) {
            $query->where('category_id', $transactionFilterParams->categoryId);
        }

        [$column, $order] = $transactionFilterParams->getSortingColumnAndOrder();
        $query->orderBy($column, $order);

        return $query->get();
    }

    /**
     * Store a new transaction.
     *
     * @param TransactionDTO $transactionDTO
     * @return bool
     */
    public function store(TransactionDTO $transactionDTO): bool
    {
        try {
            DB::transaction(function () use ($transactionDTO): void {
                Transaction::create([
                    'user_id'     => auth()->id(),
                    'category_id' => $transactionDTO->categoryId,
                    'amount'      => $transactionDTO->amount,
                    'name'        => $transactionDTO->name,
                    'date'        => $transactionDTO->date,
                ]);
            });

            return true;
        } catch (Throwable $exception) {
            Log::error('Failed to store transaction: ' . $exception->getMessage());
        }

        return false;
    }

    /**
     * Find a transaction by ID.
     *
     * @param int $id
     * @return Transaction
     */
    public function find(int $id): Transaction
    {
        return Transaction::findOrFail($id);
    }

    /**
     * Update an existing transaction.
     *
     * @param Transaction    $transaction
     * @param TransactionDTO $transactionDTO
     * @return bool
     */
    public function update(Transaction $transaction, TransactionDTO $transactionDTO): bool
    {
        return $transaction->updateOrFail($transactionDTO->toArray());
    }

    /**
     * Delete a transaction.
     *
     * @param Transaction $transaction
     * @return bool
     */
    public function delete(Transaction $transaction): bool
    {
        return $transaction->deleteOrFail();
    }
}
