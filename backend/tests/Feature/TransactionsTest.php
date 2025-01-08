<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class TransactionsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->user = User::factory()->create();
    }

    public function test_if_unauthenticated_user_can_create_transaction(): void
    {
        $response = $this->postJson('/api/transactions', [
            'user_id' => 1,
            'name' => 'Test Transaction',
            'amount' => 100,
            'category_id' => '1',
            'date' => '2021-01-01',
        ]);

        $response->assertStatus(404);
    }

    public function test_if_user_can_create_transaction(): void
    {
        $this->actingAs($this->user);

        $transactionData = [
            'name' => 'Apple Juice',
            'category_id' => Category::first()->id,
            'amount' => "5.1221",
            'date' => '2023-01-01',
        ];

        $response = $this->postJson('/api/V1/transactions', $transactionData);

        $response->assertStatus(204);
        $this->assertDatabaseHas('transactions', [
            'name' => $transactionData['name'],
            'category_id' => $transactionData['category_id'],
            'amount' => 5.12,
            'date' => $transactionData['date'],
        ]);
    }

    public function test_if_user_can_get_his_own_transactions(): void
    {
        $this->actingAs($this->user);

        $transactionData = [
            'name' => 'Apple Juice',
            'category_id' => Category::first()->id,
            'amount' => "5.1221",
            'date' => '2023-01-01',
        ];

        $this->postJson('/api/V1/transactions', $transactionData);

        $response = $this->getJson('/api/V1/transactions');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "name" => "Apple Juice",
            "amount" => "5.12",
            "date" => "01 Jan 2023",
        ]);
    }

    public function test_if_user_cant_get_others_transactions(): void
    {
        $this->actingAs($this->user);

        $transactionData = [
            'name' => 'Apple Juice',
            'category_id' => Category::first()->id,
            'amount' => "5.1221",
            'date' => '2023-01-01',
        ];

        $this->postJson('/api/V1/transactions', $transactionData);

        $response = $this->getJson('/api/V1/transactions');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "name" => "Apple Juice",
            "amount" => "5.12",
            "date" => "01 Jan 2023",
        ]);

        $this->actingAs(User::factory()->create());

        $response = $this->getJson('/api/V1/transactions');
        $response->assertStatus(200);
        $response->assertJsonMissing([
            "name" => "Apple Juice",
            "amount" => "5.12",
            "date" => "01 Jan 2023",
        ]);
    }

    public function test_if_user_can_update_transaction(): void
    {
        $this->actingAs($this->user);

        $transactionData = [
            'name' => 'Apple Juice',
            'category_id' => Category::first()->id,
            'amount' => "5.1221",
            'date' => '2023-01-01',
        ];

        $response = $this->postJson('/api/V1/transactions', $transactionData);
        $response->assertStatus(204);

        $transaction = Transaction::first();

        $updatedTransactionData = [
            'name' => 'Updated Apple Juice',
            'category_id' => Category::first()->id,
            'amount' => "5.17",
            'date' => '2024-01-01',
        ];

        $response = $this->putJson("/api/V1/transactions/{$transaction->id}", $updatedTransactionData);
        $response->assertStatus(204);
        $this->assertDatabaseHas('transactions', $updatedTransactionData);
    }

    public function test_if_user_cant_update_others_transaction(): void {
        $this->actingAs($this->user);
        $transaction = Transaction::factory()->create(
            [
                'user_id' => $this->user->id,
                'name' => 'Apple Juice',
                'category_id' => Category::first()->id,
                'amount' => "5.17",
                'date' => '2024-01-01',
            ]
        );

        $updatedTransactionData = [
            'name' => 'Updated Apple Juice',
            'category_id' => Category::first()->id,
            'amount' => "10.17",
            'date' => '2024-01-01',
        ];

        $response = $this->putJson("/api/V1/transactions/{$transaction}", $updatedTransactionData);
        $response->assertStatus(404);
        $this->assertDatabaseMissing('transactions', $updatedTransactionData);
    }

    public function test_if_user_can_delete_transaction(): void {
        $this->actingAs($this->user);
        $transactionId = Transaction::factory()->create(
            [
                'user_id' => $this->user->id,
            ]
        )->id;

        $response = $this->deleteJson("/api/V1/transactions/{$transactionId}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('transactions', [
            'id' => $transactionId,
        ]);
    }

    public function test_if_user_cant_delete_others_transactions(): void {
        $this->actingAs($this->user);
        $transactionId = Transaction::factory()->create(
            [
                'user_id' => $this->user->id,
            ]
        )->id;

        $secondUser = User::factory()->create();
        $this->actingAs($secondUser);
        $response = $this->deleteJson("/api/V1/transactions/{$transactionId}");
        $response->assertStatus(404);
    }

    public function test_transactions_index_endpoint(): void {
        $this->actingAs($this->user);
        Transaction::factory()->count(3)->create();

        $response = $this->getJson('/api/V1/transactions');
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'amount',
                    'date',
                    'category' => [
                        'id',
                        'name'
                    ],
                ],
            ],
        ]);
    }
}
