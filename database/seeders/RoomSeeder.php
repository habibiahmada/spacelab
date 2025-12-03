<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Room, Building};

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [];

        // ====== LABORATORIUM (Shared Resources) ======
        $labRooms = [
            ['code' => 'LAB01', 'name' => 'Laboratorium Komputer 1', 'building' => 'Gedung A', 'floor' => 1, 'capacity' => 40, 'type' => 'lab'],
            ['code' => 'LAB02', 'name' => 'Laboratorium Komputer 2', 'building' => 'Gedung A', 'floor' => 2, 'capacity' => 40, 'type' => 'lab'],
            ['code' => 'LAB03', 'name' => 'Laboratorium Komputer 3', 'building' => 'Gedung A', 'floor' => 3, 'capacity' => 40, 'type' => 'lab'],
            ['code' => 'LAB04', 'name' => 'Laboratorium Jaringan', 'building' => 'Gedung A', 'floor' => 1, 'capacity' => 30, 'type' => 'lab'],
            ['code' => 'LAB05', 'name' => 'Laboratorium Praktik Teknik', 'building' => 'Gedung A', 'floor' => 2, 'capacity' => 35, 'type' => 'lab'],
            ['code' => 'LAB06', 'name' => 'Laboratorium Desain Grafis', 'building' => 'Gedung A', 'floor' => 3, 'capacity' => 30, 'type' => 'lab'],
            ['code' => 'LAB07', 'name' => 'Laboratorium Mesin 1', 'building' => 'Gedung B', 'floor' => 1, 'capacity' => 35, 'type' => 'lab'],
            ['code' => 'LAB08', 'name' => 'Laboratorium Mesin 2', 'building' => 'Gedung B', 'floor' => 2, 'capacity' => 35, 'type' => 'lab'],
            ['code' => 'LAB09', 'name' => 'Laboratorium Multimedia', 'building' => 'Gedung B', 'floor' => 3, 'capacity' => 30, 'type' => 'lab'],
            ['code' => 'LAB10', 'name' => 'Laboratorium IPA', 'building' => 'Gedung C', 'floor' => 1, 'capacity' => 35, 'type' => 'lab'],
        ];
        $rooms = array_merge($rooms, $labRooms);

        // ====== KELAS REGULER (90 kelas: 10 jurusan × 9 kelas per jurusan) ======
        // Untuk 90 kelas, kita sebarkan ke 6 gedung (B-G) dengan distribusi merata
        $majors = ['RPL', 'TKJ', 'DKV', 'TSM', 'TKR', 'AKL', 'BDP', 'MP', 'KLN', 'PHT'];
        $levels = [10, 11, 12];
        $buildingSequence = ['Gedung D', 'Gedung E', 'Gedung F', 'Gedung G', 'Gedung H', 'Gedung I'];
        $buildingIndex = 0;
        $floorPerBuilding = 3; // 3 lantai per gedung
        $classPerFloor = 3;    // 3 kelas per lantai (rombel 1,2,3 per level)

        $classCounter = 0;
        foreach ($majors as $major) {
            foreach ($levels as $level) {
                for ($rombel = 1; $rombel <= 3; $rombel++) {
                    $currentBuilding = $buildingSequence[$buildingIndex % count($buildingSequence)];
                    $floor = ($classCounter % $floorPerBuilding) + 1;

                    $roomCode = "KLS_{$major}{$level}{$rombel}";
                    $roomName = "Kelas {$level} {$major} {$rombel}";

                    $rooms[] = [
                        'code' => $roomCode,
                        'name' => $roomName,
                        'building' => $currentBuilding,
                        'floor' => $floor,
                        'capacity' => 36, // Untuk 35 siswa
                        'type' => 'kelas',
                    ];

                    $classCounter++;
                    if ($classCounter % ($floorPerBuilding * $classPerFloor) == 0) {
                        $buildingIndex++;
                    }
                }
            }
        }

        // ====== RUANG KANTOR DAN GURU ======
        $officeRooms = [
            ['code' => 'RGURU01', 'name' => 'Ruang Guru', 'building' => 'Gedung D', 'floor' => 1, 'capacity' => 50, 'type' => 'kantor'],
            ['code' => 'RGURU02', 'name' => 'Ruang Guru Khusus', 'building' => 'Gedung E', 'floor' => 1, 'capacity' => 30, 'type' => 'kantor'],
            ['code' => 'RKEPSEK', 'name' => 'Ruang Kepala Sekolah', 'building' => 'Gedung D', 'floor' => 2, 'capacity' => 8, 'type' => 'kantor'],
            ['code' => 'RWAKIL', 'name' => 'Ruang Wakil Kepala Sekolah', 'building' => 'Gedung D', 'floor' => 2, 'capacity' => 6, 'type' => 'kantor'],
            ['code' => 'RTU01', 'name' => 'Ruang Tata Usaha', 'building' => 'Gedung D', 'floor' => 1, 'capacity' => 15, 'type' => 'kantor'],
            ['code' => 'RKURIKULUM', 'name' => 'Ruang Kurikulum', 'building' => 'Gedung E', 'floor' => 1, 'capacity' => 10, 'type' => 'kantor'],
        ];
        $rooms = array_merge($rooms, $officeRooms);

        // ====== FASILITAS UMUM ======
        $facilityRooms = [
            ['code' => 'RPERPUS', 'name' => 'Perpustakaan Sekolah', 'building' => 'Gedung F', 'floor' => 1, 'capacity' => 50, 'type' => 'fasilitas'],
            ['code' => 'RUKS', 'name' => 'Ruang UKS', 'building' => 'Gedung F', 'floor' => 1, 'capacity' => 8, 'type' => 'fasilitas'],
            ['code' => 'RMUSHOLLA', 'name' => 'Musholla', 'building' => 'Gedung G', 'floor' => 1, 'capacity' => 100, 'type' => 'fasilitas'],
            ['code' => 'RKANTIN', 'name' => 'Kantin Sekolah', 'building' => 'Gedung G', 'floor' => 1, 'capacity' => 80, 'type' => 'fasilitas'],
            ['code' => 'RSERBAGUNA', 'name' => 'Aula Serbaguna', 'building' => 'Gedung H', 'floor' => 1, 'capacity' => 300, 'type' => 'fasilitas'],
            ['code' => 'RGUDANG', 'name' => 'Gudang Sekolah', 'building' => 'Gedung H', 'floor' => 1, 'capacity' => 5, 'type' => 'penyimpanan'],
            ['code' => 'RLAPANGAN', 'name' => 'Lapangan Olahraga', 'building' => 'Outdoor', 'floor' => 0, 'capacity' => 200, 'type' => 'fasilitas'],
        ];
        $rooms = array_merge($rooms, $facilityRooms);

        // Persist rooms to database
        foreach ($rooms as $room) {
            $typeMap = [
                'lab' => 'lab',
                'kelas' => 'kelas',
                'aula' => 'aula',
                'kantor' => 'lainnya',
                'fasilitas' => 'lainnya',
                'penyimpanan' => 'lainnya',
            ];

            $type = $typeMap[$room['type']] ?? 'lainnya';

            // Map building name to building_id
            $building = Building::where('name', $room['building'])->first();
            $building_id = $building?->id;

            Room::create([
                'code' => $room['code'],
                'name' => $room['name'],
                'building_id' => $building_id,
                'floor' => $room['floor'] ?? null,
                'capacity' => $room['capacity'] ?? null,
                'type' => $type,
                'is_active' => true,
                'notes' => null,
            ]);
        }

        $this->command->info("✅ RoomSeeder: Created " . count($rooms) . " rooms (90 classrooms + labs + facilities).");
    }
}
