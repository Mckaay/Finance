<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\DispatchWeeklySummariesJob;
use Illuminate\Console\Command;

final class DispatchWeeklySummaryEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:weekly-summaries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch weekly summary emails to users';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        DispatchWeeklySummariesJob::dispatch();
    }
}
