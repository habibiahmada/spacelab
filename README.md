![Spacelab Banner](https://placehold.co/1200x400?text=Spacelab+Application)  
  
<h1 align="center">🚀 Spacelab</h1>
<p align="center">
  <b>Smart Academic Space & Schedule Management System</b><br/>
  <i>Efficiently manage rooms, classes, and schedules with automatic conflict detection.</i>
</p><p align="center">
  <a href="https://laravel.com" target="_blank"><img src="https://img.shields.io/badge/Laravel-11.x-red?logo=laravel&logoColor=white" alt="Laravel"></a>
  <a href="https://www.php.net/" target="_blank"><img src="https://img.shields.io/badge/PHP-8.3-blue?logo=php&logoColor=white" alt="PHP"></a>
  <a href="https://www.postgresql.org" target="_blank"><img src="https://img.shields.io/badge/PostgreSQL-15.x-blue?logo=postgresql&logoColor=white" alt="PostgreSQL"></a>
  <!-- <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-green" alt="License"></a> -->
</p>

Spacelab adalah aplikasi manajemen jadwal dan ruang akademik berbasis web yang membantu institusi pendidikan (sekolah, kampus, atau lembaga kursus) dalam:

- Mengatur jadwal kelas dan guru

- Menghindari konflik penggunaan ruangan

- Memantau pemakaian ruang secara efisien

- Menyediakan laporan dan analitik kegiatan akademik


Spacelab dibangun dengan Laravel Breeze (Blade), berfokus pada otomatisasi, akurasi, dan antarmuka pengguna yang sederhana serta cepat.


---

## 🏗️ Teknologi yang Digunakan

Layer	Teknologi

Frontend	Laravel Breeze (Blade), Tailwind CSS, Alpine.js
Backend	Laravel 11 (PHP 8.3)
Database	PostgreSQL
Cache / Queue	Redis
Deployment	Fly.io / Caddy
Testing	PHPUnit


<p align="center">
  <img src="https://plus.unsplash.com/premium_photo-1664297989345-f4ff2063b212" width=1000 height=320 alt="Tech Stack Preview" />
</p>
---

## ⚙️ Fitur Utama

✅ Manajemen Jadwal Otomatis
Kelola jadwal kelas, guru, dan ruang dalam satu sistem dengan deteksi konflik otomatis.

🏫 Pengelolaan Ruang & Gedung
Pantau ketersediaan ruangan secara real-time berdasarkan jadwal dan kapasitas.

👩‍🏫 Manajemen Data Akademik
CRUD data guru, siswa, mata pelajaran, dan tahun ajaran.

📊 Laporan & Analitik
Visualisasi data pemakaian ruang, kegiatan belajar, dan tingkat utilisasi.

🔐 Multi-Role Authentication
Peran: Admin, Guru, Siswa, Tata Usaha — masing-masing dengan hak akses berbeda.

📥 Import / Export Data
Dukungan impor file CSV/XLSX dan ekspor laporan ke Excel/PDF.


---

## 🧩 Struktur Direktori

```
spacelab/
├── app/
│   ├── Http/
│   ├── Models/
│   └── Policies/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
│   └── web.php
└── tests/
```

---

### 📸 Tampilan Antarmuka (Mockup)

<p align="center">
  <img src="https://github.com/user-attachments/assets/6c6a2577-5818-4890-828e-e9972b87e7c1" alt="Dashboard Mockup" />
</p>

---

## 🚦 Cara Instalasi

### 1️⃣ Clone Repository

```
git clone https://github.com/habibiahmada/spacelab.git

cd spacelab
```

### 2️⃣ Instal Dependensi

```
composer install

npm install && npm run build
```

### 3️⃣ Konfigurasi Environment

Buat file .env:

```
cp .env.example .env
php artisan key:generate
```

Lalu sesuaikan koneksi database (PostgreSQL):

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=spacelab
DB_USERNAME=postgres
DB_PASSWORD=yourpassword
```

### 4️⃣ Jalankan Migrasi & Seeder

```
php artisan migrate --seed
```

### 5️⃣ Jalankan Server Lokal

```
php artisan serve

Buka di browser:
👉 http://localhost:8000
```

---

## 🧠 Konsep Utama Sistem

### 🧩 Conflict Detection Logic

- Sistem akan otomatis mencegah bentrokan jadwal dengan algoritma:

- Mengecek overlap waktu antar jadwal

- Validasi guru, ruangan, dan kelas

- Memberikan peringatan saat konflik terdeteksi


### 📅 Struktur Data Jadwal (PostgreSQL)

```
CREATE TABLE schedule_entries (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  room_id uuid REFERENCES rooms(id),
  teacher_id uuid REFERENCES teachers(id),
  class_id uuid REFERENCES classes(id),
  subject_id uuid REFERENCES subjects(id),
  start_at timestamptz NOT NULL,
  end_at timestamptz NOT NULL,
  status varchar(32) DEFAULT 'confirmed'
);
```

---

🧩 Rencana Pengembangan

[ ] Kalender akademik dinamis per semester

[ ] Modul absensi berbasis jadwal

[ ] Dashboard interaktif dengan chart

[ ] Export laporan PDF dengan desain modern



---

## 👨‍💻 Pengembang

Spacelab dikembangkan secara independen oleh
Habib Ahmad Aziz (habibiahmada)
![contributors badge](https://readme-contribs.as93.net/contributors/habibiahmada/spacelab)


---
<p align="center">Made with ❤️ using Laravel 11 & Breeze (Blade)</p>

<p align="center">
<img src="https://camo.githubusercontent.com/850d1f46b6c0452b7480070f1acb1af5fff0616760ee690f869a7fa442a3bdc7/68747470733a2f2f692e6962622e636f2f344b74705978622f6f63746f6361742d636c65616e2d6d696e692e706e67" alt="Github Octocat">
</br>
thanks for visiting ; )
</p>