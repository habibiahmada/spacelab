<?php

namespace Tests\Feature\Staff;

use App\Models\Classroom;
use App\Models\Major;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MajorTest extends TestCase
{
    use RefreshDatabase;

    public function test_major_index_can_be_rendered()
    {
        $user = User::factory()->asStaff()->create();

        $response = $this->actingAs($user)->get(route('staff.majors.index'));

        $response->assertStatus(200);
    }

    public function test_can_create_major()
    {
        $user = User::factory()->asStaff()->create();

        $majorData = [
            'code' => 'M001',
            'name' => 'New Major',
            'description' => 'Major Description',
            'slogan' => 'Major Slogan',
        ];

        $response = $this->actingAs($user)->post(route('staff.majors.store'), $majorData);

        $response->assertRedirect(route('staff.majors.index'));
        $this->assertDatabaseHas('majors', [
            'code' => 'M001',
            'name' => 'New Major',
        ]);
    }

    public function test_can_update_major()
    {
        $user = User::factory()->asStaff()->create();
        $major = Major::factory()->create();

        $updateData = [
            'code' => 'M002',
            'name' => 'Updated Major',
            'description' => 'Updated Description',
        ];

        $response = $this->actingAs($user)->put(route('staff.majors.update', $major->id), $updateData);

        $response->assertRedirect(); // Redirects back
        $this->assertDatabaseHas('majors', [
            'id' => $major->id,
            'code' => 'M002',
            'name' => 'Updated Major',
        ]);
    }

    public function test_can_delete_major_without_classes()
    {
        $user = User::factory()->asStaff()->create();
        $major = Major::factory()->create();

        $response = $this->actingAs($user)->delete(route('staff.majors.destroy', $major->id));

        $response->assertRedirect(route('staff.majors.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('majors', ['id' => $major->id]);
    }

    public function test_cannot_delete_major_with_classes()
    {
        $user = User::factory()->asStaff()->create();
        $major = Major::factory()->create();
        Classroom::factory()->create(['major_id' => $major->id]);

        $response = $this->actingAs($user)->delete(route('staff.majors.destroy', $major->id));

        $response->assertRedirect(route('staff.majors.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('majors', ['id' => $major->id]);
    }
}
