<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Pot;

final class PotObserver
{
    public function created(Pot $pot): void {}

    public function updated(Pot $pot): void {}

    public function deleted(Pot $pot): void {}
}
