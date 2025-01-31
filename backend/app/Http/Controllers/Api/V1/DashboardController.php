<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Enums\CacheKey;
use App\Http\Resources\V1\BudgetResource;
use App\Http\Resources\V1\PotResource;
use App\Http\Resources\V1\TransactionResource;
use App\Repositories\BudgetRepository;
use App\Repositories\PotRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class DashboardController
{
    public function __construct(
        protected TransactionRepository $transactionRepository,
        protected BudgetRepository $budgetRepository,
        protected PotRepository $potRepository,
    ) {}

    public function index(): JsonResponse
    {

        $dashboardData = Cache::remember(
            CacheKey::DASHBOARD_DATA->value . "_user_" . auth()->id(),
            600,
            function (): array {
                $budgetCollection = $this->budgetRepository->all();
                if ( ! $budgetCollection->isEmpty()) {
                    $spendingsSum = (int) $budgetCollection->sum('monthlySpendings');
                }

                return [
                    'balance' => $this->transactionRepository->getBalance(),
                    'incomeSum' => $this->transactionRepository->getIncomesSum(),
                    'expenseSum' => $this->transactionRepository->getExpensesSum(),
                    'transactions' => TransactionResource::collection($this->transactionRepository->getDashboardData()),
                    'budgetsLimitSum' => $this->budgetRepository->getLimitSum(),
                    'budgetsExpensesSum' => $spendingsSum  ?? 0,
                    'budgets' => BudgetResource::collection($budgetCollection),
                    'pots' => PotResource::collection($this->potRepository->getDashboardData()),
                ];
            },
        );

        return response()->json(
            [
                'data' => $dashboardData,
            ],
        );
    }
}
