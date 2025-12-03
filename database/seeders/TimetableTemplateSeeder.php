<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;
use App\Models\Block;
use App\Models\TimetableTemplate;

class TimetableTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $classes = Classroom::all();
        $blocks = Block::all();

        if ($classes->isEmpty()) {
            $this->command->warn('⚠️ No classrooms found. Create classrooms first.');
            return;
        }

        if ($blocks->isEmpty()) {
            $this->command->warn('⚠️ No blocks found. Create blocks first.');
            return;
        }

        foreach ($classes as $class) {
            foreach ($blocks as $block) {
                TimetableTemplate::updateOrCreate(
                    [
                        'class_id' => $class->id,
                        'block_id' => $block->id,
                        'version'  => 'v1',
                    ],
                    [
                        'is_active' => true,
                    ]
                );
            }
        }

        $this->command->info('✅ TimetableTemplateSeeder: templates created/updated.');
    }
}
