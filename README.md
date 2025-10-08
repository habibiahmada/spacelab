![Spacelab Banner](https://placehold.co/1200x400?text=Spacelab+Application)

<h1 align="center">🚀 Spacelab</h1>
<p align="center">
  <b>Smart Academic Space & Schedule Management System</b><br/>
  <i>Efficiently manage rooms, classes, and schedules with automatic conflict detection.</i>
</p>

<p align="center">
  <a href="https://laravel.com" target="_blank"><img src="https://img.shields.io/badge/Laravel-12.x-red?logo=laravel&logoColor=white" alt="Laravel"></a>
  <a href="https://www.php.net/" target="_blank"><img src="https://img.shields.io/badge/PHP-8.3-blue?logo=php&logoColor=white" alt="PHP"></a>
  <a href="https://livewire.laravel.com" target="_blank"><img src="https://img.shields.io/badge/Livewire-3.0-purple?logo=laravel&logoColor=white" alt="Livewire"></a>
  <a href="https://www.postgresql.org" target="_blank"><img src="https://img.shields.io/badge/PostgreSQL-15.x-blue?logo=postgresql&logoColor=white" alt="PostgreSQL"></a>
  <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-green" alt="License"></a>
</p>

---

## 🧭 Deskripsi

**Spacelab** adalah aplikasi **manajemen jadwal dan ruang akademik** berbasis web yang membantu institusi pendidikan (sekolah, kampus, atau lembaga kursus) dalam:
- Mengatur jadwal kelas dan guru
- Menghindari konflik penggunaan ruangan
- Memantau pemakaian ruang secara efisien
- Menyediakan laporan dan analitik kegiatan akademik

Spacelab dirancang dengan fokus pada **otomatisasi**, **akurasi**, dan **pengalaman pengguna yang intuitif**.

---

## 🏗️ Teknologi yang Digunakan

| Layer | Teknologi |
|-------|------------|
| **Frontend** | Laravel Livewire, Blade, Tailwind CSS |
| **Backend** | Laravel 12 (PHP 8.3) |
| **Database** | PostgreSQL |
| **Cache / Queue** | Redis |
| **Deployment** | FlyEnv / Caddy |
| **Testing** | PHPUnit, PestPHP |

<p align="center">
  <img src="https://source.unsplash.com/800x400/?database,code" alt="Tech Stack Preview" />
</p>

---

## ⚙️ Fitur Utama

✅ **Manajemen Jadwal Otomatis**  
Kelola jadwal kelas, guru, dan ruang dalam satu sistem dengan deteksi konflik otomatis.

🏫 **Pengelolaan Ruang & Gedung**  
Pantau ketersediaan ruangan secara real-time berdasarkan jadwal dan kapasitas.

👩‍🏫 **Manajemen Data Akademik**  
CRUD data guru, siswa, mata pelajaran, dan tahun ajaran.

📊 **Laporan & Analitik**  
Visualisasi data pemakaian ruang, kegiatan belajar, dan tingkat utilisasi.

🔐 **Multi-Role Authentication**  
Peran: Admin, Guru, Siswa, Tata Usaha — masing-masing dengan hak akses berbeda.

📥 **Import / Export Data**  
Dukungan impor file CSV/XLSX dan ekspor laporan ke Excel/PDF.

---

## 🧩 Struktur Modul

```

spacelab/
├── app/
│   ├── Http/
│   ├── Models/
│   ├── Livewire/
│   └── Policies/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   └── css/
├── routes/
│   └── web.php
└── tests/

````

---

## 📸 Tampilan Antarmuka (Mockup)

<p align="center">
  <img src="https://source.unsplash.com/1000x500/?dashboard,analytics" alt="Dashboard Mockup" />
</p>

---

## 🚦 Cara Instalasi

### 1️⃣ Clone Repository
```bash
git clone https://github.com/username/spacelab.git
cd spacelab
````

### 2️⃣ Instal Dependensi

```bash
composer install
npm install && npm run build
```

### 3️⃣ Konfigurasi Environment

Buat file `.env`:

```bash
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

```bash
php artisan migrate --seed
```

### 5️⃣ Jalankan Server Lokal

```bash
php artisan serve
```

Buka di browser:
👉 **[http://localhost:8000](http://localhost:8000)**

---

## 🧠 Konsep Utama Sistem

### 🧩 Conflict Detection Logic

Sistem akan otomatis mencegah bentrokan jadwal dengan algoritma:

* Mengecek **overlap waktu** antar jadwal
* Validasi **guru, ruangan, dan kelas**
* Memberikan peringatan saat konflik terdeteksi

### 📅 Struktur Data Jadwal (PostgreSQL)

```sql
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

## 🧩 Rencana Pengembangan

* [ ] Integrasi dengan sensor ruangan (IoT-ready)
* [ ] Kalender akademik dinamis per semester
* [ ] Modul absensi berbasis jadwal
* [ ] Dashboard interaktif dengan chart Livewire
* [ ] Export laporan PDF dengan desain modern

---

## 👨‍💻 Pengembang

**Spacelab** dikembangkan oleh tim di bawah bimbingan
**CV SmartPlus Indonesia** (2025)

> Sistem manajemen ruang & jadwal akademik modern berbasis Laravel.

---

## 🏷️ Tags

`#Laravel` `#Livewire` `#PostgreSQL` `#SchoolSystem` `#SchedulingApp` `#SpaceManagement` `#EducationTech` `#SmartCampus`

---

<p align="center">
  <img src="https://source.unsplash.com/900x250/?space,abstract" alt="Footer Banner"/>
</p>

<p align="center">Made with ❤️ using Laravel 12 & Livewire</p>
```
