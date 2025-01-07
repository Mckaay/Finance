<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

final class CategorySeeder extends Seeder
{
    /**
     * Seeds the database with default categories coming from categories.json file.
     */
    public function run(): void
    {
        $filePath = database_path("json/categories.json");
        if ( ! file_exists($filePath)) {
            return;
        }

        $categoriesFromJsonFile = json_decode(file_get_contents($filePath), true);
        if (empty($categoriesFromJsonFile)) {
            return;
        }

        foreach ($categoriesFromJsonFile as $category) {
            Category::factory()->create([
                'name' => $category['name'],
            ]);
        }
    }
}
