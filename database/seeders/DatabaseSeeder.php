<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            BuildingSeeder::class,
            RoomSeeder::class,
            SubjectSeeder::class,
            PeriodSeeder::class,
            TermSeeder::class,
            BlockSeeder::class,
            MajorSeeder::class,
            ClassSeeder::class,
            TeacherSeeder::class,
            RoleAssignmentSeeder::class,
            StudentSeeder::class,
            TimetableSeeder::class,
            NotificationSeeder::class,
            ImportJobSeeder::class,
            AuditLogSeeder::class,
            ReportSeeder::class,
            RoomHistorySeeder::class,
            GuardianClassHistorySeeder::class,
        ]);
    }
}
