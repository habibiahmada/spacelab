<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{RoleAssignment, Major, User, Term};

class RoleAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $term = Term::where('is_active', true)->first();

        if (! $term) {
            $this->command->warn('⚠️ Tidak ada term aktif. Jalankan TermSeeder dulu.');
            return;
        }

        $majors = Major::all();
        $teachers = \App\Models\Teacher::all();

        if ($majors->isEmpty() || $teachers->isEmpty()) {
            $this->command->warn('⚠️ Pastikan ada jurusan dan guru terlebih dahulu.');
            return;
        }

        $usedTeacherIds = [];
        foreach ($majors as $major) {
            // pick head and coordinator that are not used yet in this term and not conflicting
            $candidatesForHead = $teachers->whereNotIn('id', $usedTeacherIds);
            if ($candidatesForHead->isEmpty()) {
                $head = $teachers->random();
            } else {
                $head = $candidatesForHead->random();
            }
            $usedTeacherIds[] = $head->id;

            $availableCoordinators = $teachers->whereNotIn('id', $usedTeacherIds);
            if ($availableCoordinators->isEmpty()) {
                $coordinator = $teachers->random();
            } else {
                $coordinator = $availableCoordinators->random();
            }
            $usedTeacherIds[] = $coordinator->id;

            RoleAssignment::updateOrCreate(
                ['major_id' => $major->id, 'terms_id' => $term->id],
                ['head_of_major_id' => $head->id, 'program_coordinator_id' => $coordinator->id]
            );
        }

        $this->command->info('✅ RoleAssignmentSeeder: role assignments for majors created for active term.');
    }
}
