<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * Test if there is a default file for categories seeder.
     */
    public function test_default_categories_file_exist(): void
    {
        $filePath = database_path("json/categories.json");
        $this->assertFileExists($filePath);

        $categories = json_decode(file_get_contents($filePath), true);
        $this->assertIsArray($categories);
        $this->assertNotEmpty($categories);
    }

    /**
     * Test if there are at least 6 default categories after seeding.
     */
    public function test_there_are_at_least_six_categories_after_seeding(): void
    {
        $defaultCategories = Category::all();
        $this->assertCount(6, $defaultCategories);
    }

    /**
     * Test if categories basic endpoint gives specific response.
     */
    public function test_if_endpoint_returns_success_response(): void
    {
        $response = $this->getJson('api/V1/categories');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'value',
                    'label',
                ],
            ],
        ]);
    }

    /**
     * Test if basic endpoint is cached.
     */
    public function test_if_basic_endpoint_is_cached(): void
    {
        Cache::flush();
        $response = $this->getJson('api/V1/categories');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'value',
                    'label',
                ],
            ],
        ]);

        $this->assertTrue(Cache::has('categories'));
    }
}
