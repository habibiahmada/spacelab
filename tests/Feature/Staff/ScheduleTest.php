<?php

namespace Tests\Feature\Staff;

use App\Models\Classroom;
use App\Models\Major;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_schedule_index_can_be_rendered()
    {
        $user = User::factory()->asStaff()->create();

        $response = $this->actingAs($user)->get(route('staff.schedules.index'));

        $response->assertStatus(200);
    }

    public function test_can_fetch_major_schedules()
    {
        $user = User::factory()->asStaff()->create();
        $major = Major::factory()->create();
        Classroom::factory()->create(['major_id' => $major->id]);

        $response = $this->actingAs($user)->get(route('staff.schedules.major', $major->id));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'classes'
        ]);
    }
}
