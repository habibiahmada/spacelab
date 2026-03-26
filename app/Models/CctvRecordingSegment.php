<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CctvRecordingSegment extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'room_id',
        'camera_type',
        'record_mode',
        'segment_start_at',
        'segment_end_at',
        'duration_seconds',
        'file_path',
        'file_size_bytes',
        'codec',
        'resolution',
        'has_motion',
        'integrity_status',
    ];

    protected $casts = [
        'segment_start_at' => 'datetime',
        'segment_end_at' => 'datetime',
        'has_motion' => 'boolean',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
