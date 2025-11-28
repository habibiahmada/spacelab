<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function scheduleEntries(): HasMany
    {
        return $this->hasMany(TimetableEntry::class, 'teacher_id');
    }

    public function timetableEntries(): HasMany
    {
        return $this->hasMany(TimetableEntry::class, 'teacher_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects_', 'teacher_id', 'subject_id')
            ->withTimestamps()
            ->withPivot(['started_at', 'ended_at']);
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
