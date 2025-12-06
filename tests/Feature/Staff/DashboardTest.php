<?php

namespace Tests\Feature\Staff;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_dashboard_screen_can_be_rendered()
    {
        $user = User::factory()->asStaff()->create();

        $response = $this->actingAs($user)->get(route('staff.index'));

        $response->assertStatus(200);
    }

    public function test_non_staff_users_cannot_access_staff_dashboard()
    {
        $user = User::factory()->asStudent()->create();

        $response = $this->actingAs($user)->get(route('staff.index'));

        $response->assertStatus(403);
    }
}
