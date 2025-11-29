<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;

class BuildingSeeder extends Seeder
{
    public function run(): void
    {
        $buildings = [
            ['code' => 'G_A', 'name' => 'Gedung A'],
            ['code' => 'G_B', 'name' => 'Gedung B'],
            ['code' => 'G_C', 'name' => 'Gedung C'],
            ['code' => 'G_D', 'name' => 'Gedung D'],
            ['code' => 'G_E', 'name' => 'Gedung E'],
            ['code' => 'G_F', 'name' => 'Gedung F'],
            ['code' => 'G_G', 'name' => 'Gedung G'],
            ['code' => 'G_H', 'name' => 'Gedung H'],
        ];

        foreach ($buildings as $b) {
            Building::updateOrCreate(['code' => $b['code']], $b);
        }

        $this->command->info('✅ BuildingSeeder: ' . count($buildings) . ' buildings seeded.');
    }
}
