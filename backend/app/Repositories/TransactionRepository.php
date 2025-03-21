<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataObjects\TransactionDTO;
use App\DataObjects\TransactionFilterParams;
use App\Models\Transaction;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
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
     * @return LengthAwarePaginator
     */
    public function all(TransactionFilterParams $transactionFilterParams): LengthAwarePaginator
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

        return $query->paginate(10);
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
                    ...$transactionDTO->toArray(),
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

    /**
     * Get monthly spending transactions for categories.
     *
     * @param Collection $categories
     * @param int $limit
     * @return Collection
     */
    public function getMonthlySpendingsForCategories(Collection $categories, int $limit = 3): Collection
    {
        return Transaction::whereIn('category_id', $categories)
            ->where('amount', '<', 0)
            ->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])
            ->orderBy('date', 'desc')
            ->get();
    }

    public function getDashboardData(int $limit = 5): Collection
    {
        return Transaction::query()->latest('date')->limit($limit)->get();
    }

    public function getBalance()
    {
        return Transaction::query()->sum('amount');
    }

    public function getIncomesSum()
    {
        return Transaction::where('amount', '>', 0)->sum('amount');
    }

    public function getExpensesSum()
    {
        return Transaction::where('amount', '<', 0)->sum('amount');
    }
}
