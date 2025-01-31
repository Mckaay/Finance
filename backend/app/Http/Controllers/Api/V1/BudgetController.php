<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\DataObjects\BudgetDTO;
use App\Http\Requests\V1\StoreBudgetRequest;
use App\Http\Requests\V1\UpdateBudgetRequest;
use App\Http\Resources\V1\BudgetResource;
use App\Http\Resources\V1\CategoryResource;
use App\Http\Resources\V1\ThemeResource;
use App\Models\Budget;
use App\Repositories\BudgetRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ThemeRepository;
use Illuminate\Http\JsonResponse;

final class BudgetController
{
    public function __construct(protected BudgetRepository $budgetRepository) {}

    public function index(): JsonResponse
    {
        $budgetCollection = $this->budgetRepository->all();

        if ( ! $budgetCollection->isEmpty()) {
            $sumOfMonthlySpendings = (int) $budgetCollection->sum('monthlySpendings');
        }

        return response()->json([
            'data' => [
                'limitSum' => $this->budgetRepository->getLimitSum(),
                'expensesSum' => $sumOfMonthlySpendings ?? 0,
                'budgets' => BudgetResource::collection($budgetCollection),
            ],
        ]);
    }

    public function store(StoreBudgetRequest $request): JsonResponse
    {
        $this->budgetRepository->store(BudgetDTO::fromRequest($request));

        return response()->json(
            status: 201,
        );
    }

    public function update(Budget $budget, UpdateBudgetRequest $request): JsonResponse
    {
        $this->budgetRepository->update($budget, BudgetDTO::fromRequest($request));

        return response()->json(
            status: 204,
        );
    }

    public function delete(Budget $budget): JsonResponse
    {
        $this->budgetRepository->delete($budget);

        return response()->json(
            status: 204,
        );
    }

    public function getAvailableOptions(): JsonResponse
    {
        return response()->json([
            'data' => [
                'categories' => CategoryResource::collection(CategoryRepository::getAvailableCategoriesForBudget()),
                'themes' => ThemeResource::collection(ThemeRepository::getAvailableThemesForBudget()),
            ],
        ]);
    }
}
