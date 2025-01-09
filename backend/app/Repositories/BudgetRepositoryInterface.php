<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataObjects\BudgetDTO;
use App\Models\Budget;
use Illuminate\Support\Collection;

interface BudgetRepositoryInterface
{
    public function all(): Collection;
    public function store(BudgetDTO $budgetDTO): bool;
    public function update(Budget $budget, BudgetDTO $budgetDTO): bool;
    public function delete(Budget $budget): bool;
    public function find(int $id): Budget;
}
