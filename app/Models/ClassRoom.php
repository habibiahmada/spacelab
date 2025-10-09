<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Classroom extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'classes'; 

    protected $fillable = [
        'level',
        'rombel',
        'major_id',
        'term_id',
        'homeroom_teacher_id'
    ];

    // Relasi ke jurusan
    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    // Relasi ke tahun ajaran (terms)
    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    // Wali kelas
    public function homeroomTeacher()
    {
        return $this->belongsTo(Teacher::class, 'homeroom_teacher_id');
    }

    // Siswa dalam kelas
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    // Jadwal kelas
    public function scheduleEntries()
    {
        return $this->hasMany(ScheduleEntry::class, 'class_id');
    }

    // Helper: nama lengkap kelas
    public function getFullNameAttribute()
    {
        return "{$this->level} {$this->major->code} {$this->rombel}";
    }
}