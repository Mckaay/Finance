<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

final class ThemeSeeder extends Seeder
{
    /**
     * Import default themes from themes.json file.
     */
    public function run(): void
    {
        $filePath = database_path("json/themes.json");
        if ( ! file_exists($filePath)) {
            return;
        }

        $themes = json_decode(file_get_contents($filePath), true);
        if ( ! $themes) {
            return;
        }

        foreach ($themes as $theme) {
            Theme::factory()->create(
                [
                    'name' => $theme['name'],
                    'color' => $theme['color'],
                ],
            );
        }
    }
}
