<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanGetTheirOwnVehicle()
    {
        $john = User::factory()->create();
        $vehicleForJhon = Vehicle::factory()->create([
            'user_id' => $john->id,
        ]);


        $adam = User::factory()->create();
        $vehicleForAdam = Vehicle::factory()->create([
            'user_id' => $adam->id,
        ]);

        $response = $this->actingAs($john)->getJson('/api/v1/vehicles');

        $response->assertStatus(200)
                ->assertJsonStructure(['data'])
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.plate_number', $vehicleForJhon->plate_number)
                ->assertJsonMissing($vehicleForAdam->toArray());
    }

    public function testUserCanCreateVehicle()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/v1/vehicles', [
            'plate_number' => 'B0823TB',
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure(['data'])
                ->assertJsonCount(2, 'data')
                ->assertJsonStructure([
                    'data' => ['0' => 'plate_number']
                ])
                ->assertJsonPath('data.plate_number', 'B0823TB');

        $this->assertDatabaseHas('vehicles', [
            'plate_number' => 'B0823TB'
        ]);
    }

    public function testUserCanUpdateTheirVehicle()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->putJson('/api/v1/vehicles/'. $vehicle->id, [
            'plate_number' => 'AAA8008',
        ]);

        $response->assertStatus(202)
                ->assertJsonStructure(['plate_number'])
                ->assertJsonPath('plate_number', 'AAA8008');

        $this->assertDatabaseHas('vehicles', [
            'plate_number' => 'AAA8008',
        ]);
    }

    public function testUserCanDeleteTheirVehicle()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson('/api/v1/vehicles/'. $vehicle->id);

        $response->assertNoContent();

        $this->assertDatabaseMissing('vehicles', [
            'id' => $vehicle->id,
            'deleted_at' => null,
        ])->assertDatabaseCount('vehicles', 1);
    }
}
