<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\PotTransaction;

final class PotTransactionObserver
{
    public function created(PotTransaction $potTransaction): void {}

    public function updated(PotTransaction $potTransaction): void {}

    public function deleted(PotTransaction $potTransaction): void {}
}
