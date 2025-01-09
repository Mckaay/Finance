<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataObjects\BudgetDTO;
use App\Models\Budget;
use App\Models\Transaction;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Repository for managing transactions.
 */
final class BudgetRepository implements BudgetRepositoryInterface
{
    public function all(): Collection
    {
        $budgets = Budget::with(['category', 'theme'])->get();
        $categoryIds = $budgets->pluck('category_id');

        $transactions = Transaction::whereIn('category_id', $categoryIds)
            ->where('amount', '<', 0)
            ->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])
            ->get();
        $transactionsByCategory = $transactions->groupBy('category_id');

        $budgets->each(function ($budget) use ($transactionsByCategory): void {
            $budget->transactions = $transactionsByCategory->get($budget->category_id, collect());
            $budget->monthlySpendings = (string) $budget->transactions->sum('amount');
        });

        return $budgets;
    }


    public function store(BudgetDTO $budgetDTO): bool
    {
        try {
            DB::transaction(function () use ($budgetDTO): bool {
                Budget::create([
                    'user_id' => auth()->id(),
                    'limit' => $budgetDTO->limit,
                    'category_id' => $budgetDTO->categoryId,
                    'theme_id' => $budgetDTO->themeId,
                ]);

                return true;
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }

        return false;
    }

    public function update(Budget $budget, BudgetDTO $budgetDTO): bool
    {
        return $budget->updateOrFail($budgetDTO->toArray());
    }

    public function delete(Budget $budget): bool
    {
        return $budget->deleteOrFail();
    }

    public function find(int $id): Budget
    {
        return Budget::findOrFail($id);
    }
}
