<?php

namespace Tests\Feature\Student;

use App\Models\Classroom;
use App\Models\Major;
use App\Models\Room;
use App\Models\TimetableEntry;
use App\Models\TimetableTemplate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomClassroomTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_see_classroom_name_in_room_list()
    {
        // 1. Setup Data
        $studentUser = User::factory()->create();

        $major = Major::factory()->create(['code' => 'RPL']);
        $classroom = Classroom::factory()->create([
            'level' => 10,
            'major_id' => $major->id,
            'rombel' => '1',
        ]);

        $template = TimetableTemplate::factory()->create([
            'class_id' => $classroom->id,
            'is_active' => true,
        ]);

        $room = Room::factory()->create(['name' => 'Lab 1', 'code' => 'R101']);

        $todayDay = Carbon::now()->isoWeekday();

        $entry = TimetableEntry::factory()->create([
            'template_id' => $template->id,
            'day_of_week' => $todayDay,
        ]);

        // 2. Act
        $response = $this->actingAs($studentUser)
            ->get(route('siswa.rooms.index'));

        // 3. Assert - Check that page loads successfully and shows room data
        $response->assertStatus(200);
        $response->assertSee('Lab 1'); // Room name should be visible
        $response->assertSee('Daftar Ruangan'); // Page title
    }
}
