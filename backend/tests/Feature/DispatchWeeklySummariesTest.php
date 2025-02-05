<?php

declare(strict_types=1);

namespace Tests\Feature\Jobs;

use App\Jobs\DispatchWeeklySummariesJob;
use App\Mail\WeeklySummaryEmail;
use App\Models\Transaction;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

final class DispatchWeeklySummariesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }


    public function test_if_dispatches_the_job_successfully(): void
    {
        Queue::fake();
        Artisan::call('send:weekly-summaries');
        Queue::assertPushed(DispatchWeeklySummariesJob::class);
    }

    public function test_if_sends_weekly_summary_email_if_transactions_exist(): void
    {
        Mail::fake();

        $this->seed(CategorySeeder::class);

        $user = User::factory()->create();
        Transaction::factory()->create([
            'user_id' => $user->id,
            'date' => now()->startOfWeek()->addDay(),
        ]);

        Queue::fake();
        Artisan::call('send:weekly-summaries');
        Queue::assertPushed(DispatchWeeklySummariesJob::class);

        $job = new DispatchWeeklySummariesJob();
        $job->handle();

        Mail::assertSent(WeeklySummaryEmail::class);
    }

    public function test_if_does_not_send_email_if_no_transactions_exist(): void
    {
        Mail::fake();
        $user = User::factory()->create();
        (new DispatchWeeklySummariesJob())->handle();
        Mail::assertNothingSent();
    }
}
