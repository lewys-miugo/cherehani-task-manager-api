<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_authenticated_user_can_create_task()
{
    $user = \App\Models\User::factory()->create();

    $response = $this->actingAs($user)
        ->postJson('/api/tasks', [
            'title' => 'Test Task',
            'due_date' => now()->addDay()->format('Y-m-d'),
        ]);

    $response->assertStatus(201);
}
}
