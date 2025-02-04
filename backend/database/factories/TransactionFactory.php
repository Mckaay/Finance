<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
final class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'amount' => $this->faker->randomFloat(2, -2000, 2000),
            'date' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'user_id' => User::first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
