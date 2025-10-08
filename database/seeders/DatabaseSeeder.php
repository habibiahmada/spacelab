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
            ClassSeeder::class,
            StudentSeeder::class,
            TermSeeder::class,
            ScheduleSeeder::class,
            NotificationSeeder::class,
            ImportJobSeeder::class,
            AuditLogSeeder::class,
            ReportSeeder::class,
        ]);
    }
}
