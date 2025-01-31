<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Budget;

final class BudgetObserver
{
    public function created(Budget $budget): void {}

    public function updated(Budget $budget): void {}

    public function deleted(Budget $budget): void {}
}
