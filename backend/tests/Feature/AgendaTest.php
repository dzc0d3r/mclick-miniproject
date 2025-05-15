<?php

namespace Tests\Feature;

use App\Models\Agenda;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgendaTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $otherUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();
    }

    /** @test */
    public function user_can_create_an_agenda()
    {
        $data = [
            'title' => 'Test Agenda',
            'description' => 'Test description'
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/agendas', $data);

        $response->assertStatus(201)
            ->assertJson(array_merge($data, [
                'user_id' => $this->user->id
            ]));

        $this->assertDatabaseHas('agendas', array_merge($data, [
            'user_id' => $this->user->id
        ]));
    }

    // Other test methods...
}