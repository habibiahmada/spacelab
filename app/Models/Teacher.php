<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Teacher extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'phone', 'user_id', 'code', 'avatar'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * All timetable entries for this teacher via the teacher_subjects pivot.
     * The TimetableEntry does not directly contain a `teacher_id` column, it references a teacher_subject.
     */
    public function scheduleEntries(): HasManyThrough
    {
        return $this->hasManyThrough(
            TimetableEntry::class,
            TeacherSubject::class,
            'teacher_id', // Foreign key on TeacherSubject table
            'teacher_subject_id', // Foreign key on TimetableEntry table
            'id', // Local key on Teacher table
            'id' // Local key on TeacherSubject table
        );
    }

    /**
     * Alias for scheduleEntries to preserve any legacy usage.
     */
    public function timetableEntries(): HasManyThrough
    {
        return $this->scheduleEntries();
    }

    public function teacherSubjects(): HasMany
    {
        return $this->hasMany(TeacherSubject::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects', 'teacher_id', 'subject_id')
            ->withTimestamps()
            ->withPivot(['started_at', 'ended_at']);
    }
    
    public function guardianClassHistories(): HasMany
    {
        return $this->hasMany(GuardianClassHistory::class, 'teacher_id');
    }

    public function roleAssignments(): HasMany
    {
        return $this->hasMany(RoleAssignment::class, 'head_of_major_id');
    }

    public function asCoordinatorAssignments(): HasMany
    {
        return $this->hasMany(RoleAssignment::class, 'program_coordinator_id');
    }

}
