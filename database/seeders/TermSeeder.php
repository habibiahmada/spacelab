<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Term;
use Illuminate\Support\Str;

class TermSeeder extends Seeder
{
    public function run(): void
    {
        Term::create([
            'id' => (string) Str::uuid(),
            'name' => 'Semester Genap 2025',
            'start_date' => '2025-01-10',
            'end_date' => '2025-06-30',
            'is_active' => true
        ]);
    }
}
