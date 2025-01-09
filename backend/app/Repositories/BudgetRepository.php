<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataObjects\BudgetDTO;
use App\Models\Budget;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Repository for managing transactions.
 */
final class BudgetRepository implements BudgetRepositoryInterface
{
    public function __construct(protected TransactionRepository $transactionRepository) {}

    public function all(): Collection
    {
        $budgets = Budget::with(['category', 'theme'])->get();
        $categories = $budgets->pluck('category_id');

        $transactions = $this->transactionRepository->getMonthlySpendingsForCategories($categories);
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
