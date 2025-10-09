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
            RoomSeeder::class,
            SubjectSeeder::class,
            TeacherSeeder::class,
            TermSeeder::class,
            MajorSeeder::class,
            ClassSeeder::class,
            StudentSeeder::class,
            ScheduleSeeder::class,
            NotificationSeeder::class,
            ImportJobSeeder::class,
            AuditLogSeeder::class,
            ReportSeeder::class,
        ]);
    }
}
