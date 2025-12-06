<?php

namespace Tests\Feature\Staff;

use App\Models\Classroom;
use App\Models\Major;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassroomTest extends TestCase
{
    use RefreshDatabase;

    public function test_classroom_index_can_be_rendered()
    {
        $user = User::factory()->asStaff()->create();

        $response = $this->actingAs($user)->get(route('staff.classrooms.index'));

        $response->assertStatus(200);
    }

    public function test_can_create_classroom()
    {
        $user = User::factory()->asStaff()->create();
        $major = Major::factory()->create();

        $response = $this->actingAs($user)->post(route('staff.classrooms.store'), [
            'level' => 10,
            'major_id' => $major->id,
            'rombel' => 1,
        ]);

        $response->assertRedirect(route('staff.classrooms.index'));
        $this->assertDatabaseHas('classes', [
            'level' => 10,
            'major_id' => $major->id,
            'rombel' => 1,
        ]);
    }

    public function test_can_update_classroom()
    {
        $user = User::factory()->asStaff()->create();
        $classroom = Classroom::factory()->create([
            'level' => 10,
            'rombel' => 1
        ]);
        $major = $classroom->major;

        $response = $this->actingAs($user)->put(route('staff.classrooms.update', $classroom->id), [
            'level' => 11,
            'major_id' => $major->id,
            'rombel' => 2,
        ]);

        $response->assertRedirect(route('staff.classrooms.index'));
        $this->assertDatabaseHas('classes', [
            'id' => $classroom->id,
            'level' => 11,
            'major_id' => $major->id,
            'rombel' => 2,
        ]);
    }

    public function test_can_delete_classroom()
    {
        $user = User::factory()->asStaff()->create();
        $classroom = Classroom::factory()->create();

        $response = $this->actingAs($user)->delete(route('staff.classrooms.destroy', $classroom->id));

        $response->assertRedirect(route('staff.classrooms.index'));
        $this->assertDatabaseMissing('classes', ['id' => $classroom->id]);
    }
}
