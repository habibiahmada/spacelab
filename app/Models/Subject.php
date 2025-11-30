<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['code', 'name', 'type', 'description'];

    public function scheduleEntries(): HasMany
    {
        return $this->hasMany(TimetableEntry::class, 'subject_id');
    }

    public function teacherSubjects(): HasMany
    {
        return $this->hasMany(TeacherSubject::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subjects', 'subject_id', 'teacher_id')
            ->withTimestamps()
            ->withPivot(['started_at', 'ended_at']);
    }

    public function majorSubjects(): HasMany
    {
        return $this->hasMany(MajorSubject::class, 'subject_id');
    }

    public function allowedMajors()
    {
        return $this->hasMany(SubjectMajorAllowed::class, 'subject_id');
    }
    
    public function majors() // existing many-to-many through major_subject
    {
        return $this->belongsToMany(Major::class, 'major_subject', 'subject_id', 'major_id')
                    ->withTimestamps()
                    ->withPivot(['notes']);
    }
}