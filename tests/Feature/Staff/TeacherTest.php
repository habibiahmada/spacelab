<?php

namespace Tests\Feature\Staff;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_index_can_be_rendered()
    {
        $user = User::factory()->asStaff()->create();

        $response = $this->actingAs($user)->get(route('staff.teachers.index'));

        $response->assertStatus(200);
    }
}
