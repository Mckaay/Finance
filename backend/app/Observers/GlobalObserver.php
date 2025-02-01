<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\CacheKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

final class GlobalObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(Model $model): void
    {
        $this->clearCache();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(Model $model): void
    {
        $this->clearCache();
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(Model $model): void
    {
        $this->clearCache();
    }

    public function clearCache(): void
    {
        Cache::forget(CacheKey::DASHBOARD_DATA->value . "_user_" . auth()->id());
    }

}
