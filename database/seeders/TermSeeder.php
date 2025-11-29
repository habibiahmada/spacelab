<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Term;

class TermSeeder extends Seeder
{
    public function run(): void
    {
        Term::create([
            'tahun_ajaran' => '2025/2026',
            'start_date' => '2025-07-10',
            'end_date' => '2026-06-15',
            'is_active' => true,
            'kind' => 'genap'
        ]);
    }
}
