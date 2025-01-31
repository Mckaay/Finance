<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Transaction;

final class TransactionObserver
{
    public function created(Transaction $transaction): void {}

    public function updated(Transaction $transaction): void {}

    public function deleted(Transaction $transaction): void {}
}
