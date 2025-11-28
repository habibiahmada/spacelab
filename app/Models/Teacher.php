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
        'staff_id', 'name', 'email', 'phone', 'subjects', 'available_hours', 'user_id', 'image'
    ];
    protected $casts = [
        'subjects' => 'array',
        'available_hours' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scheduleEntries(): HasMany
    {
        return $this->hasMany(ScheduleEntry::class);
    }

    public function homeroomClasses(): HasMany
    {
        return $this->hasMany(ClassRoom::class, 'homeroom_teacher_id');
    }

    public function majorsAsHead()
    {
        return $this->hasMany(Major::class, 'head_of_major_id');
    }

    public function majorsAsCoordinator()
    {
        return $this->hasMany(Major::class, 'program_coordinator_id');
    }

}
