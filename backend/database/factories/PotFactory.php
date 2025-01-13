<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Pot;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pot>
 */
final class PotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $themes = Theme::all()->pluck('id')->toArray();

        return [
            'user_id' => User::factory()->create()->id,
            'name' => $this->faker->unique()->name(),
            'target' => $this->faker->numberBetween(1, 50000),
            'theme_id' => $this->faker->unique()->randomElement($themes),
        ];
    }
}
