<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

final class ThemesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * Test if there is a default file for themes seeder.
     */
    public function test_default_themes_file_exist(): void
    {
        $filePath = database_path("json/themes.json");
        $this->assertFileExists($filePath);

        $themes = json_decode(file_get_contents($filePath), true);
        $this->assertIsArray($themes);
        $this->assertNotEmpty($themes);
    }

    /**
     * Test if there are at least 15 default themes after seeding.
     */
    public function test_there_are_at_least_fifteen_themes_after_seeding(): void
    {
        $defaultThemes = Theme::all();
        $this->assertCount(15, $defaultThemes);
    }

    /**
     * Test if themes basic endpoint gives specific response.
     */
    public function test_if_endpoint_returns_success_response(): void
    {
        $response = $this->getJson('api/V1/themes');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'value',
                    'label',
                    'color',
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
        $response = $this->getJson('api/V1/themes');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'value',
                    'label',
                    'color',
                ],
            ],
        ]);

        $this->assertTrue(Cache::has('themes'));
    }
}
