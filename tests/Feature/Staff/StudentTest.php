<?php

namespace Tests\Feature\Staff;

use App\Models\ClassHistory;
use App\Models\Classroom;
use App\Models\Role;
use App\Models\Student;
use App\Models\Term;
use App\Models\User;
use App\Models\Block;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    protected $activeTerm;
    protected $block;
    protected $role;

    protected function setUp(): void
    {
        parent::setUp();
        // Create active term and block
        $this->activeTerm = Term::factory()->create(['is_active' => true]);
        $this->block = Block::create([
             'terms_id' => $this->activeTerm->id,
             'name' => 'Block 1',
             'start_date' => now(),
             'end_date' => now()->addMonths(3)
        ]);

        // Ensure student role exists
        $this->role = Role::firstOrCreate(['name' => 'Siswa']);
    }

    public function test_student_index_can_be_rendered()
    {
        $user = User::factory()->asStaff()->create();

        $response = $this->actingAs($user)->get(route('staff.students.index'));

        $response->assertStatus(200);
    }

    public function test_student_show_can_be_rendered()
    {
        $user = User::factory()->asStaff()->create();
        $student = Student::factory()->create();
        $classroom = Classroom::factory()->create();

        // Create ClassHistory
        ClassHistory::create([
            'student_id' => $student->id,
            'class_id' => $classroom->id,
            'terms_id' => $this->activeTerm->id,
            'block_id' => $this->block->id,
        ]);

        $response = $this->actingAs($user)->get(route('staff.students.show', $student->id));

        $response->assertStatus(200);
    }

    public function test_can_create_student()
    {
        $user = User::factory()->asStaff()->create();
        $classroom = Classroom::factory()->create();

        $studentData = [
            'name' => 'Test Student',
            'email' => 'student@test.com',
            'nis' => '12345',
            'nisn' => '1234567890',
            'classroom_id' => $classroom->id,
        ];

        $response = $this->actingAs($user)->post(route('staff.students.store'), $studentData);

        $response->assertRedirect(); // Should redirect back
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'nis' => '12345',
            'nisn' => '1234567890',
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'Test Student',
            'email' => 'student@test.com',
        ]);
        // Verify ClassHistory created
        $newStudent = Student::where('nis', '12345')->first();
        $this->assertDatabaseHas('classhistories', [
            'student_id' => $newStudent->id,
            'class_id' => $classroom->id,
            'terms_id' => $this->activeTerm->id,
        ]);
    }

    public function test_can_update_student()
    {
        $user = User::factory()->asStaff()->create();
        $student = Student::factory()->create();
        $classroom = Classroom::factory()->create();

        // Initial ClassHistory
        ClassHistory::create([
            'student_id' => $student->id,
            'class_id' => $classroom->id,
            'terms_id' => $this->activeTerm->id,
            'block_id' => $this->block->id,
        ]);

        $newClassroom = Classroom::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@test.com',
            'nis' => '54321',
            'nisn' => '0987654321',
            'classroom_id' => $newClassroom->id,
        ];

        $response = $this->actingAs($user)->put(route('staff.students.update', $student->id), $updateData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'nis' => '54321',
            'nisn' => '0987654321',
        ]);

        // Verify ClassHistory updated
        $this->assertDatabaseHas('classhistories', [
            'student_id' => $student->id,
            'class_id' => $newClassroom->id,
        ]);
    }

    public function test_can_delete_student()
    {
        $user = User::factory()->asStaff()->create();
        $student = Student::factory()->create();
        $classroom = Classroom::factory()->create();

        ClassHistory::create([
            'student_id' => $student->id,
            'class_id' => $classroom->id,
            'terms_id' => $this->activeTerm->id,
            'block_id' => $this->block->id,
        ]);

        $response = $this->actingAs($user)->delete(route('staff.students.destroy', $student->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
        $this->assertDatabaseMissing('users', ['id' => $student->users_id]);
    }
}
