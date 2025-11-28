<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'code', 'name', 'building_id', 'floor', 'capacity', 'type', 'is_active', 'notes'
    ];

    public function timetableEntries(): HasMany
    {
        return $this->hasMany(TimetableEntry::class, 'room_id');
    }

    public function scheduleEntries(): HasMany
    {
        return $this->hasMany(TimetableEntry::class, 'room_id');
    }

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
}
