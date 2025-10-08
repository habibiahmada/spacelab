<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'room_id', 'date', 'total_usage_hours', 'total_idle_hours', 'utilization_rate', 'generated_at'
    ];
    protected $casts = [
        'date' => 'date',
        'generated_at' => 'datetime'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
