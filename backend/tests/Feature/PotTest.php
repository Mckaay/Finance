<?php

declare(strict_types=1);

namespace Feature;

use App\Models\Pot;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

final class PotTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_user_can_create_pot(): void
    {
        $user = User::factory()->create();

        $response = $this->createPot($user);
        $response->assertStatus(201);

        $this->assertDatabaseHas('pots', [
            'name' => 'Default Name',
            'target' => 2000,
            'theme_id' => Theme::first()->id,
        ]);
    }

    public function test_unauthenticated_user_cant_create_pot(): void
    {
        $potData = [
            'name' => 'Default Name',
            'target' => "2000",
            'theme_id' => Theme::first()->id,
        ];

        $response = $this->postJson(route('pots:store'), $potData);
        $response->assertStatus(401);
        $this->assertDatabaseMissing('pots', $potData);
    }

    public function test_user_cannot_store_pot_with_duplicate_theme(): void
    {
        $user = User::factory()->create();

        $potDataOne = [
            'name' => 'First Name',
            'target' => "2000",
            'theme_id' => Theme::first()->id,
        ];

        $potDataTwo = [
            'name' => 'Second name',
            'target' => "2000",
            'theme_id' => Theme::first()->id,
        ];

        $this->createPot($user,$potDataOne)->assertStatus(201);
        $this->assertDatabaseHas('pots',$potDataOne);

        $this->createPot($user,$potDataTwo)->assertStatus(422);
    }

    public function test_user_can_update_their_pot(): void
    {
        $user = User::factory()->create();
        $this->createPot($user)->assertStatus(201);

        $potId = Pot::first()->id;

        $updatedData = [
            'name' => 'Updated name',
            'target' => "2000",
            'theme_id' => Theme::inRandomOrder()->first()->id,
        ];

        $response = $this->putJson(route('pots:update', [$potId]), $updatedData)->assertStatus(204);
        $this->assertDatabaseHas('pots', $updatedData);
    }

    public function test_user_cannot_update_others_budget(): void
    {
        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create();

        $this->createPot($firstUser)->assertStatus(201);
        $potId = Pot::first()->id;

        $updatedData = [
            'name' => 'Updated name',
            'target' => "2000",
            'theme_id' => Theme::inRandomOrder()->first()->id,
        ];

        $this->actingAs($secondUser);

        $this->putJson(route('pots:update', [$potId]), $updatedData)
            ->assertStatus(404);
    }

    public function test_user_cannot_delete_others_budget(): void
    {
        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create();

        $this->createPot($firstUser)->assertStatus(201);
        $potId = Pot::first()->id;

        $this->actingAs($secondUser);

        $this->deleteJson(route('pots:delete', [$potId]))
            ->assertStatus(404);
    }

    private function createPot(User $user, array $data = []): TestResponse
    {
        $this->actingAs($user);

        $defaultData = [
            'name' => 'Default Name',
            'target' => "2000",
            'theme_id' => Theme::first()->id,
        ];

        return $this->postJson(route('pots:store'), array_merge($defaultData, $data));
    }
}
