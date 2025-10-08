<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::create([
            'code' => 'LAB01',
            'name' => 'Laboratorium Komputer 1',
            'building' => 'Gedung A',
            'floor' => 1,
            'capacity' => 30,
            'type' => 'lab',
            'resources' => ['PC', 'Projector', 'WiFi'],
        ]);

        Room::create([
            'code' => 'KLS01',
            'name' => 'Kelas 12 RPL 1',
            'building' => 'Gedung B',
            'floor' => 2,
            'capacity' => 36,
            'type' => 'kelas',
            'resources' => ['Whiteboard', 'AC'],
        ]);
    }
}
