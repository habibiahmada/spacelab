<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use Illuminate\Support\Str;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        Room::insert([
            [
                'id' => (string) Str::uuid(),
                'code' => 'LAB01',
                'name' => 'Laboratorium Komputer 1',
                'building' => 'Gedung A',
                'floor' => 1,
                'capacity' => 30,
                'type' => 'lab',
                'resources' => json_encode(['PC', 'Projector', 'WiFi']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'code' => 'KLS01',
                'name' => 'Kelas 12 RPL 1',
                'building' => 'Gedung B',
                'floor' => 2,
                'capacity' => 36,
                'type' => 'kelas',
                'resources' => json_encode(['Whiteboard', 'AC']),
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}
