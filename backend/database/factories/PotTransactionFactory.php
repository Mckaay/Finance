<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PotTransactionType;
use App\Models\Pot;
use App\Models\PotTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PotTransaction>
 */
final class PotTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pots = Pot::query()
            ->withoutGlobalScopes()
            ->get()
            ->pluck('id')
            ->toArray();

        return [
            'type' => $this->faker->randomElement(PotTransactionType::cases()),
            'amount' => $this->faker->randomFloat(2, 0, 10000),
            'pot_id' => $this->faker->randomElement($pots),
        ];
    }
}
