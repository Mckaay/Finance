<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PotTransaction;
use Illuminate\Database\Seeder;

final class PotTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PotTransaction::factory()->count(50)->create();
    }
}
