<?php

namespace Tests\Feature\Staff;

use App\Models\Building;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    public function test_room_index_can_be_rendered()
    {
        $user = User::factory()->asStaff()->create();

        $response = $this->actingAs($user)->get(route('staff.rooms.index'));

        $response->assertStatus(200);
    }

    public function test_can_create_building()
    {
        $user = User::factory()->asStaff()->create();

        $buildingData = [
            'code' => 'GDA',
            'name' => 'Gedung A',
            'description' => 'Gedung utama',
            'total_floors' => 3,
        ];

        $response = $this->actingAs($user)->post(route('staff.buildings.store'), $buildingData);

        $response->assertRedirect(route('staff.rooms.index'));
        $this->assertDatabaseHas('building', [
            'code' => 'GDA',
            'name' => 'Gedung A',
        ]);
    }

    public function test_can_update_building()
    {
        $user = User::factory()->asStaff()->create();
        $building = Building::factory()->create();

        $updateData = [
            'code' => 'GDB',
            'name' => 'Gedung B Updated',
            'total_floors' => 4,
        ];

        $response = $this->actingAs($user)->put(route('staff.buildings.update', $building->id), $updateData);

        $response->assertRedirect(route('staff.rooms.index'));
        $this->assertDatabaseHas('building', [
            'id' => $building->id,
            'code' => 'GDB',
            'name' => 'Gedung B Updated',
        ]);
    }

    public function test_can_delete_building_without_rooms()
    {
        $user = User::factory()->asStaff()->create();
        $building = Building::factory()->create();

        $response = $this->actingAs($user)->delete(route('staff.buildings.destroy', $building->id));

        $response->assertRedirect(route('staff.rooms.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('building', ['id' => $building->id]);
    }

    public function test_cannot_delete_building_with_rooms()
    {
        $user = User::factory()->asStaff()->create();
        $building = Building::factory()->create();
        Room::factory()->create(['building_id' => $building->id]);

        $response = $this->actingAs($user)->delete(route('staff.buildings.destroy', $building->id));

        $response->assertRedirect(route('staff.rooms.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('building', ['id' => $building->id]);
    }

    public function test_can_create_room()
    {
        $user = User::factory()->asStaff()->create();
        $building = Building::factory()->create();

        $roomData = [
            'code' => 'R001',
            'name' => 'Ruang Kelas 1',
            'building_id' => $building->id,
            'floor' => 1,
            'capacity' => 30,
            'type' => 'kelas',
            'is_active' => true,
        ];

        $response = $this->actingAs($user)->post(route('staff.rooms.store'), $roomData);

        $response->assertRedirect(route('staff.rooms.index'));
        $this->assertDatabaseHas('rooms', [
            'code' => 'R001',
            'name' => 'Ruang Kelas 1',
            'building_id' => $building->id,
        ]);
    }

    public function test_can_update_room()
    {
        $user = User::factory()->asStaff()->create();
        $building = Building::factory()->create();
        $room = Room::factory()->create(['building_id' => $building->id]);

        $updateData = [
            'code' => 'R002',
            'name' => 'Ruang Lab Updated',
            'building_id' => $building->id,
            'floor' => 2,
            'capacity' => 40,
            'type' => 'lab',
            'is_active' => true,
        ];

        $response = $this->actingAs($user)->put(route('staff.rooms.update', $room->id), $updateData);

        $response->assertRedirect(route('staff.rooms.index'));
        $this->assertDatabaseHas('rooms', [
            'id' => $room->id,
            'code' => 'R002',
            'name' => 'Ruang Lab Updated',
        ]);
    }

    public function test_can_delete_room()
    {
        $user = User::factory()->asStaff()->create();
        $building = Building::factory()->create();
        $room = Room::factory()->create(['building_id' => $building->id]);

        $response = $this->actingAs($user)->delete(route('staff.rooms.destroy', $room->id));

        $response->assertRedirect(route('staff.rooms.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }
}
