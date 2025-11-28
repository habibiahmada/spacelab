<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomHistory extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'room_history';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'room_id', 'event_type', 'classes_id', 'terms_id', 'teacher_id', 'user_id'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'classes_id');
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'terms_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
