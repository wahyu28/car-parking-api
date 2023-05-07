<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanGetTheriProfile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/v1/profile');

        $response->assertStatus(200)
                ->assertJsonStructure(['name', 'email'])
                ->assertJsonCount(2)
                ->assertJsonFragment(['name' => $user->name]);
    }

    public function testUserCanUpdateNameAndEmail()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/profile', [
            'name' => 'Jhon Updated',
            'email' => 'jhonupdatedemail@gmail.com',
        ]);

        $response->assertStatus(202)
                ->assertJsonStructure(['name', 'email'])
                ->assertJsonCount(2)
                ->assertJsonFragment(['name' => 'Jhon Updated']);

        $this->assertDatabaseHas('users', [
            'name' => 'Jhon Updated',
            'email' => 'jhonupdatedemail@gmail.com',
        ]);
    }

    public function testUserCanChangePassword()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password' => 'password',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(202);
    }
}
