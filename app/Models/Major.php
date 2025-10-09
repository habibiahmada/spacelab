<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Major extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['code', 'name', 'description'];

    // Relasi ke Class (1 jurusan punya banyak kelas)
    public function classes()
    {
        return $this->hasMany(Classroom::class, 'major_id');
    }

    // Jika kamu tambahkan major_id di students
    public function students()
    {
        return $this->hasMany(Student::class, 'major_id');
    }
}
