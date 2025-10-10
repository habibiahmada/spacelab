<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            // ====== LABORATORIUM ======
            [
                'code' => 'LAB01',
                'name' => 'Laboratorium Komputer 1',
                'building' => 'Gedung A',
                'floor' => 1,
                'capacity' => 30,
                'type' => 'lab',
                'resources' => ['PC', 'Projector', 'WiFi', 'AC'],
            ],
            [
                'code' => 'LAB02',
                'name' => 'Laboratorium Komputer 2',
                'building' => 'Gedung A',
                'floor' => 2,
                'capacity' => 30,
                'type' => 'lab',
                'resources' => ['PC', 'Projector', 'WiFi', 'AC'],
            ],
            [
                'code' => 'LAB03',
                'name' => 'Laboratorium Jaringan',
                'building' => 'Gedung A',
                'floor' => 3,
                'capacity' => 25,
                'type' => 'lab',
                'resources' => ['Router', 'Switch', 'LAN Tester', 'WiFi'],
            ],

            // ====== KELAS RPL ======
            [
                'code' => 'KLS_RPL10A',
                'name' => 'Kelas 10 RPL 1',
                'building' => 'Gedung B',
                'floor' => 1,
                'capacity' => 36,
                'type' => 'kelas',
                'resources' => ['Whiteboard', 'AC', 'Kursi', 'Meja'],
            ],
            [
                'code' => 'KLS_RPL11A',
                'name' => 'Kelas 11 RPL 1',
                'building' => 'Gedung B',
                'floor' => 2,
                'capacity' => 36,
                'type' => 'kelas',
                'resources' => ['Whiteboard', 'AC', 'Kursi', 'Meja'],
            ],
            [
                'code' => 'KLS_RPL12A',
                'name' => 'Kelas 12 RPL 1',
                'building' => 'Gedung B',
                'floor' => 3,
                'capacity' => 36,
                'type' => 'kelas',
                'resources' => ['Whiteboard', 'AC', 'Kursi', 'Meja'],
            ],

            // ====== KELAS TKJ ======
            [
                'code' => 'KLS_TKJ10A',
                'name' => 'Kelas 10 TKJ 1',
                'building' => 'Gedung C',
                'floor' => 1,
                'capacity' => 36,
                'type' => 'kelas',
                'resources' => ['Whiteboard', 'Kipas Angin', 'Kursi', 'Meja'],
            ],
            [
                'code' => 'KLS_TKJ11A',
                'name' => 'Kelas 11 TKJ 1',
                'building' => 'Gedung C',
                'floor' => 2,
                'capacity' => 36,
                'type' => 'kelas',
                'resources' => ['Whiteboard', 'AC', 'Kursi', 'Meja'],
            ],
            [
                'code' => 'KLS_TKJ12A',
                'name' => 'Kelas 12 TKJ 1',
                'building' => 'Gedung C',
                'floor' => 3,
                'capacity' => 36,
                'type' => 'kelas',
                'resources' => ['Whiteboard', 'AC', 'Kursi', 'Meja'],
            ],

            // ====== RUANG KANTOR DAN GURU ======
            [
                'code' => 'RGURU01',
                'name' => 'Ruang Guru',
                'building' => 'Gedung D',
                'floor' => 1,
                'capacity' => 20,
                'type' => 'kantor',
                'resources' => ['Meja Guru', 'Lemari Dokumen', 'WiFi', 'Printer'],
            ],
            [
                'code' => 'RKEPSEK',
                'name' => 'Ruang Kepala Sekolah',
                'building' => 'Gedung D',
                'floor' => 2,
                'capacity' => 5,
                'type' => 'kantor',
                'resources' => ['Meja Kerja', 'Sofa Tamu', 'AC'],
            ],
            [
                'code' => 'RTU01',
                'name' => 'Ruang Tata Usaha',
                'building' => 'Gedung D',
                'floor' => 1,
                'capacity' => 10,
                'type' => 'kantor',
                'resources' => ['PC', 'Printer', 'Lemari Arsip', 'WiFi'],
            ],

            // ====== FASILITAS UMUM ======
            [
                'code' => 'RPERPUS',
                'name' => 'Perpustakaan Sekolah',
                'building' => 'Gedung E',
                'floor' => 1,
                'capacity' => 40,
                'type' => 'fasilitas',
                'resources' => ['Rak Buku', 'PC', 'WiFi'],
            ],
            [
                'code' => 'RUKS',
                'name' => 'Ruang UKS',
                'building' => 'Gedung E',
                'floor' => 1,
                'capacity' => 6,
                'type' => 'fasilitas',
                'resources' => ['Tempat Tidur', 'Kotak P3K', 'Kipas Angin'],
            ],
            [
                'code' => 'RMUSHOLLA',
                'name' => 'Musholla Al-Ilab',
                'building' => 'Gedung F',
                'floor' => 1,
                'capacity' => 100,
                'type' => 'fasilitas',
                'resources' => ['Karpet', 'Sound System', 'Tempat Wudhu'],
            ],
            [
                'code' => 'RKANTIN',
                'name' => 'Kantin Sekolah',
                'building' => 'Gedung G',
                'floor' => 1,
                'capacity' => 50,
                'type' => 'fasilitas',
                'resources' => ['Meja Makan', 'Kursi', 'Kulkas', 'Wastafel'],
            ],
            [
                'code' => 'RSERBAGUNA',
                'name' => 'Aula Serbaguna',
                'building' => 'Gedung H',
                'floor' => 1,
                'capacity' => 200,
                'type' => 'fasilitas',
                'resources' => ['Panggung', 'Sound System', 'Projector', 'Kursi'],
            ],
            [
                'code' => 'RGUDANG',
                'name' => 'Gudang Sekolah',
                'building' => 'Gedung H',
                'floor' => 1,
                'capacity' => 5,
                'type' => 'penyimpanan',
                'resources' => ['Rak', 'Kardus', 'Peralatan Kebersihan'],
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }

        $this->command->info('✅ RoomSeeder berhasil menambahkan ' . count($rooms) . ' ruangan sekolah.');
    }
}
