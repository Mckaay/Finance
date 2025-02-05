<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\WeeklySummaryEmail;
use App\Models\Transaction;
use App\Models\User;
use App\Scopes\UserScope;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

final class DispatchWeeklySummariesJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        User::chunk(300, function (Collection $users): void {
            foreach ($users as $user) {
                $transactions = Transaction::where('user_id', $user->id)
                    ->withoutGlobalScopes([UserScope::class])
                    ->whereBetween(
                        'date',
                        [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
                    )
                    ->get();
                if ($transactions->isEmpty()) {
                    continue;
                }
                Mail::to($user)->send(new WeeklySummaryEmail($user, $transactions));
            }
        });
    }
}
