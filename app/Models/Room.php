<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Room extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'code', 'name', 'building_id', 'floor', 'capacity', 'type', 'is_active', 'notes',
    ];

    public function timetableEntries(): HasManyThrough
    {
        return $this->hasManyThrough(
            TimetableEntry::class,
            RoomHistory::class,
            'room_id',
            'room_history_id',
            'id',
            'id'
        );
    }

    public function directTimetableEntries(): HasManyThrough
    {
        // Alias for timetableEntries for consistency with Teacher model
        return $this->timetableEntries();
    }

    public function scheduleEntries(): HasManyThrough
    {
        return $this->timetableEntries();
    }

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    // ← TAMBAHAN: relasi langsung ke RoomHistory
    public function roomHistories(): HasMany
    {
        return $this->hasMany(RoomHistory::class, 'room_id');
    }

    public function roomHistory(): HasMany
    {
        return $this->roomHistories();
    }

    // CCTV Relations
    public function cctvPolicy()
    {
        return $this->hasOne(CctvCameraPolicy::class, 'room_id');
    }

    public function cctvHealthLogs(): HasMany
    {
        return $this->hasMany(CctvCameraHealthLog::class, 'room_id');
    }

    public function cctvEvents(): HasMany
    {
        return $this->hasMany(CctvCameraEvent::class, 'room_id');
    }

    public function cctvSegments(): HasMany
    {
        return $this->hasMany(CctvRecordingSegment::class, 'room_id');
    }

    public function latestHealthLog()
    {
        return $this->hasOne(CctvCameraHealthLog::class, 'room_id')
            ->latest('checked_at')
            ->latest('created_at');
    }
}
