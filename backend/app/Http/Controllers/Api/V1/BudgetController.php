<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\DataObjects\BudgetDTO;
use App\Http\Requests\V1\StoreBudgetRequest;
use App\Http\Requests\V1\UpdateBudgetRequest;
use App\Http\Resources\V1\BudgetResource;
use App\Models\Budget;
use App\Repositories\BudgetRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class BudgetController
{
    public function __construct(protected BudgetRepository $budgetRepository) {}

    public function index(): AnonymousResourceCollection
    {
        return BudgetResource::collection($this->budgetRepository->all());
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
}
