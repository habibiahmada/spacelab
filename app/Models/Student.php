<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nis', 'nisn', 'class_id', 'guardian_name', 'phone', 'user_id'
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
