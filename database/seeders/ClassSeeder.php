<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassRoom;
use App\Models\Teacher;
use App\Models\Major;
use App\Models\Term;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $teacher = Teacher::where('name', 'Andi Setiawan, S.Kom')->first();

        Classroom::create([
            'level' => 10,
            'rombel' => '1',
            'major_id' => Major::where('code', 'RPL')->first()->id,
            'term_id' => Term::where('is_active', true)->first()->id,
        ]);
    }
}
