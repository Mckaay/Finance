<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Budget>
 */
final class BudgetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = Category::pluck('id')->toArray();
        $themes = Theme::pluck('id')->toArray();

        return [
            'user_id' => User::factory()->create(),
            'limit' => $this->faker->numberBetween(50, 2000),
            'category_id' => $this->faker->unique()->randomElement($categories),
            'theme_id' => $this->faker->unique()->randomElement($themes),
        ];
    }
}
