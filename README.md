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

Spacelab is a web-based academic schedule and room management application that helps educational institutions (schools, campuses, and training centers) with:

- Managing class schedules and teachers
- Preventing room booking conflicts
- Monitoring room utilization efficiently
- Providing reports and analytics for academic activities

Spacelab is built using Laravel Breeze (Blade) and focuses on automation, accuracy, and a simple, fast user interface.


---

## 🏗️ Technology Stack

Layer	Technology

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

## ⚙️ Key Features

✅ Automatic Schedule Management
Manage class, teacher, and room schedules in a single system with automatic conflict detection.

🏫 Room & Building Management
Monitor room availability in real-time based on schedules and capacities.

👩‍🏫 Academic Data Management
CRUD operations for teachers, students, subjects, and academic years.

📊 Reports & Analytics
Visualize room usage, learning activities, and utilization metrics.

🔐 Multi-Role Authentication
Roles: Admin, Teacher, Student, and Administrative Staff — each with specific access rights.

📥 Import / Export Data
Support for CSV/XLSX import and exporting reports to Excel/PDF.


---

## 🧩 Directory Structure

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

### 📸 UI Mockup

<p align="center">
  <img src="https://github.com/user-attachments/assets/6c6a2577-5818-4890-828e-e9972b87e7c1" alt="Dashboard Mockup" />
</p>

---

## 🚦 Installation Guide

### 1️⃣ Clone the Repository

```
git clone https://github.com/habibiahmada/spacelab.git

cd spacelab
```

### 2️⃣ Install Dependencies

```
composer install

npm install && npm run build
```

### 3️⃣ Configure Environment

Create the `.env` file from the example:

```
cp .env.example .env
php artisan key:generate
```

Then update the database connection settings (PostgreSQL):

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=spacelab
DB_USERNAME=postgres
DB_PASSWORD=yourpassword
```

### 4️⃣ Run Migrations & Seeders

```
php artisan migrate --seed
```

### 5️⃣ Run the Local Server

```
php artisan serve

Open in browser:
👉 http://localhost:8000
```

---

## 🧠 Core System Concepts

### 🧩 Conflict Detection Logic

- The system automatically prevents schedule conflicts using logic that:

- Checks for overlapping time ranges
- Validates teacher, room, and class availability
- Displays warnings when conflicts are detected


### 📅 Schedule Data Structure (PostgreSQL)

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

🧩 Roadmap & Future Enhancements

- [ ] Dynamic academic calendar by semester

- [ ] Attendance module tied to schedule

- [ ] Interactive dashboard with charts

- [ ] PDF report export with modern design



---

## 👨‍💻 Developer

Spacelab is independently developed by
Habib Ahmad Aziz (habibiahmada)
![contributors badge](https://readme-contribs.as93.net/contributors/habibiahmada/spacelab)


---
<p align="center">Made with ❤️ using Laravel 11 & Breeze (Blade)</p>

<p align="center">
<img src="https://camo.githubusercontent.com/850d1f46b6c0452b7480070f1acb1af5fff0616760ee690f869a7fa442a3bdc7/68747470733a2f2f692e6962622e636f2f344b74705978622f6f63746f6361742d636c65616e2d6d696e692e706e67" alt="Github Octocat">
</br>
thanks for visiting ; )
</p>