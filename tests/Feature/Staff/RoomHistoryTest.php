<?php

namespace Tests\Feature\Staff;

use App\Models\Room;
use App\Models\RoomHistory;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Models\Term;
use App\Models\User;
use App\Models\Major;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomHistoryTest extends TestCase
{
    use RefreshDatabase;

    protected $staff;

    protected function setUp(): void
    {
        parent::setUp();
        $this->staff = User::factory()->create();
    }

    protected function loginAsStaff()
    {
        // Assuming App\Models\Role exists and User belongsTo Role
        if (class_exists(\App\Models\Role::class)) {
            $role = \App\Models\Role::firstOrCreate(['name' => 'Staff']);
            $this->staff->role_id = $role->id;
            $this->staff->save();
        }
        $this->actingAs($this->staff);
    }

    public function test_can_view_room_history_index()
    {
        $this->loginAsStaff();

        $response = $this->get(route('staff.rooms.history'));

        $response->assertStatus(200);
        $response->assertViewIs('staff.roomhistory.index');
    }

    public function test_can_create_room_history()
    {
        $this->loginAsStaff();

        $room = Room::factory()->create();
        $term = Term::first() ?? Term::create(['tahun_ajaran' => '2024/2025', 'is_active' => true, 'kind' => 'ganjil', 'start_date' => now(), 'end_date' => now()->addMonth()]);

        $major = Major::create(['code' => 'T1', 'name' => 'Test Major']);
        $class = Classroom::create(['level' => '10', 'major_id' => $major->id, 'rombel' => '1']);

        $teacherUser = User::factory()->create();
        $teacher = Teacher::create(['user_id' => $teacherUser->id, 'code' => 'TEA1', 'phone' => '08123']);

        $data = [
            'room_id' => $room->id,
            'terms_id' => $term->id,
            'classes_id' => $class->id,
            'teacher_id' => $teacher->id,
            'event_type' => 'Test Event',
        ];

        $response = $this->post(route('staff.rooms.history.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('room_history', [
            'room_id' => $room->id,
            'event_type' => 'Test Event',
        ]);
    }

    public function test_can_update_room_history()
    {
        $this->loginAsStaff();

        $term = Term::first() ?? Term::create(['tahun_ajaran' => '2024/2025', 'is_active' => true, 'kind' => 'ganjil', 'start_date' => now(), 'end_date' => now()->addMonth()]);
        $room = Room::factory()->create();

        $major = Major::create(['code' => 'T2', 'name' => 'Test Major 2']);
        $class = Classroom::create(['level' => '11', 'major_id' => $major->id, 'rombel' => '1']);

        $teacherUser = User::factory()->create();
        $teacher = Teacher::create(['user_id' => $teacherUser->id, 'code' => 'TEA2', 'phone' => '08124']);

        $history = RoomHistory::create([
             'room_id' => $room->id,
             'terms_id' => $term->id,
             'classes_id' => $class->id,
             'teacher_id' => $teacher->id,
             'user_id' => $this->staff->id,
             'event_type' => 'Old Event'
        ]);

        $response = $this->put(route('staff.rooms.history.update', $history->id), [
            'room_id' => $room->id,
            'terms_id' => $term->id,
            'classes_id' => $class->id,
            'teacher_id' => $teacher->id,
            'event_type' => 'New Event'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('room_history', [
            'id' => $history->id,
            'event_type' => 'New Event',
        ]);
    }

    public function test_can_delete_room_history()
    {
        $this->loginAsStaff();

        $term = Term::first() ?? Term::create(['tahun_ajaran' => '2024/2025', 'is_active' => true, 'kind' => 'ganjil', 'start_date' => now(), 'end_date' => now()->addMonth()]);
        $room = Room::factory()->create();

        $major = Major::create(['code' => 'T3', 'name' => 'Test Major 3']);
        $class = Classroom::create(['level' => '12', 'major_id' => $major->id, 'rombel' => '1']);

        $teacherUser = User::factory()->create();
        $teacher = Teacher::create(['user_id' => $teacherUser->id, 'code' => 'TEA3', 'phone' => '08125']);

        $history = RoomHistory::create([
             'room_id' => $room->id,
             'terms_id' => $term->id,
             'classes_id' => $class->id,
             'teacher_id' => $teacher->id,
             'user_id' => $this->staff->id,
             'event_type' => 'Delete Me'
        ]);

        $response = $this->delete(route('staff.rooms.history.destroy', $history->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('room_history', [
            'id' => $history->id,
        ]);
    }
}
