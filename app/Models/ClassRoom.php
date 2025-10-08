<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassRoom extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'classes';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'name', 'level', 'academic_year', 'homeroom_teacher_id'
    ];

    public function homeroomTeacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'homeroom_teacher_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function scheduleEntries(): HasMany
    {
        return $this->hasMany(ScheduleEntry::class, 'class_id');
    }
}
