<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class BudgetsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_user_can_create_budget(): void
    {
        $user = User::factory()->create();

        $this->createBudget($user);

        $this->assertDatabaseHas('budgets', [
            'limit' => 2000,
            'category_id' => Category::first()->id,
            'theme_id' => Theme::first()->id,
        ]);
    }

    public function test_unauthenticated_user_cant_create_budget(): void
    {
        $budgetData = [
            'limit' => "2000",
            'category_id' => 1,
            'theme_id' => 1,
        ];

        $this->postJson(route('budgets:store'), $budgetData)
            ->assertStatus(401);
    }

    public function test_user_cannot_store_budget_with_duplicate_category(): void
    {
        $user = User::factory()->create();

        $this->createBudget($user);

        $duplicateData = [
            'limit' => "2000",
            'category_id' => Category::first()->id,
            'theme_id' => Theme::inRandomOrder()->first()->id,
        ];

        $this->postJson(route('budgets:store'), $duplicateData)
            ->assertStatus(422);
    }

    public function test_user_cannot_store_budget_with_duplicate_theme(): void
    {
        $user = User::factory()->create();

        $this->createBudget($user);

        $duplicateThemeData = [
            'limit' => "2000",
            'category_id' => Category::inRandomOrder()->first()->id,
            'theme_id' => Theme::first()->id,
        ];

        $this->postJson(route('budgets:store'), $duplicateThemeData)
            ->assertStatus(422);
    }

    public function test_user_can_update_their_budget(): void
    {
        $user = User::factory()->create();
        $budgetId = $this->createAndGetBudgetId($user);

        $updatedData = [
            'limit' => "1000",
            'category_id' => Category::first()->id,
            'theme_id' => Theme::first()->id,
        ];

        $this->updateBudget($user, $budgetId, $updatedData);

        $this->assertDatabaseHas('budgets', [
            'id' => $budgetId,
            'limit' => 1000,
            'category_id' => Category::first()->id,
            'theme_id' => Theme::first()->id,
        ]);
    }

    public function test_user_cannot_update_others_budget(): void
    {
        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create();

        $budgetId = $this->createAndGetBudgetId($firstUser);

        $updatedData = [
            'limit' => "2000",
            'category_id' => Category::first()->id,
            'theme_id' => Theme::first()->id,
        ];

        $this->actingAs($secondUser);

        $this->putJson(route('budgets:update', [$budgetId]), $updatedData)
            ->assertStatus(404);
    }

    public function test_user_cannot_delete_others_budget(): void
    {
        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create();

        $budgetId = $this->createAndGetBudgetId($firstUser);

        $this->actingAs($secondUser);

        $this->deleteJson(route('budgets:delete', [$budgetId]))
            ->assertStatus(404);
    }

    private function createBudget(User $user, array $data = []): void
    {
        $this->actingAs($user);

        $defaultData = [
            'limit' => "2000",
            'category_id' => Category::first()->id,
            'theme_id' => Theme::first()->id,
        ];

        $this->postJson(route('budgets:store'), array_merge($defaultData, $data))
            ->assertStatus(201);
    }

    private function createAndGetBudgetId(User $user, array $data = []): int
    {
        $this->createBudget($user, $data);

        return Budget::first()->id;
    }

    private function updateBudget(User $user, int $budgetId, array $data): void
    {
        $this->actingAs($user);

        $this->putJson(route('budgets:update', [$budgetId]), $data)
            ->assertStatus(204);
    }
}
