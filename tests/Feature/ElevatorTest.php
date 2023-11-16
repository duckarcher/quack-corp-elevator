<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\Elevator;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ElevatorTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    public function test_user_can_call_the_elevator()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('api/elevator/call');

        $response->assertSuccessful();
        $response->assertJson([
            'floor' => $user->current_floor
        ]);
    }

    public function test_users_cannot_use_elevator_that_is_not_in_the_same_floor()
    {
        $floorUser = -3;
        $floorElevator = -2;
        $targetFloor = $this->faker()->numberBetween(-1, 7);

        $user = User::factory()->inFloor($floorUser)->create();
        Sanctum::actingAs($user);

        $elevator = Elevator::factory()->inFloor($floorElevator)->create();

        $response = $this->postJson('api/elevator/use', [
            'elevator_id' => $elevator->id,
            'target_floor' => $targetFloor
        ]);

        $response->assertForbidden();
        $response->assertJson(['message' => 'you have to be in the same floor']);

        $elevator->refresh();
        $user->refresh();

        $this->assertNotEquals($user->current_floor, $targetFloor);
        $this->assertNotEquals($elevator->floor, $targetFloor);
    }

    public function test_users_can_go_to_allowed_floors()
    {
        foreach (Role::cases() as $role) {
            $allowedFloors = $role->allowedFloors();

            $user = User::factory()->withRole($role)->create();
            Sanctum::actingAs($user);

            $elevator = Elevator::factory()->inFloor($user->current_floor)->create();

            foreach ($allowedFloors as $floor) {
                $response = $this->postJson('api/elevator/use', [
                    'elevator_id' => $elevator->id,
                    'target_floor' => $floor
                ]);

                $response->assertSuccessful();

                $elevator->refresh();
                $user->refresh();

                $this->assertEquals($user->current_floor, $floor);
                $this->assertEquals($elevator->floor, $floor);
            }
        }

    }

    public function test_users_cannot_go_to_restricted_floors()
    {
        foreach (Role::cases() as $role) {
            $user = User::factory()->withRole($role)->create();
            Sanctum::actingAs($user);

            $elevator = Elevator::factory()->inFloor($user->current_floor)->create();

            $userRestrictedFloors = $user->role->restrictedFloors();

            foreach ($userRestrictedFloors as $floor) {
                $response = $this->postJson('api/elevator/use', [
                    'elevator_id' => $elevator->id,
                    'target_floor' => $floor
                ]);

                $response->assertForbidden();
                $response->assertJson(['message' => 'Restricted floor']);
                $this->assertNotEquals($user->current_floor, $floor);
                $this->assertNotEquals($elevator->floor, $floor);
            }
        }
    }
}
