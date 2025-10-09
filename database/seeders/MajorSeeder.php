<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Major::create(['code' => 'RPL', 'name' => 'Rekayasa Perangkat Lunak']);
        Major::create(['code' => 'TKJ', 'name' => 'Teknik Komputer Jaringan']);
    }
}
