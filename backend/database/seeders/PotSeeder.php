<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Pot;
use App\Models\User;
use Illuminate\Database\Seeder;

final class PotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pot::factory()->count(5)->create(
            [
                'user_id' => User::first()->id,
            ],
        );
    }
}
