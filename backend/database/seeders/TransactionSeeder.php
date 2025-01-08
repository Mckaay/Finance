<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

final class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::factory()->count(60)->create(
            [
                'user_id' => User::first()->id,
            ],
        );

        Transaction::factory()->count(60)->create(
            [
                'user_id' =>  User::factory()->create()->id,
            ],
        );
    }
}
