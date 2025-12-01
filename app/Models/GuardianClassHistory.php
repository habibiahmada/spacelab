<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuardianClassHistory extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'guardian_class_history';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['teacher_id', 'class_id', 'started_at', 'ended_at'];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime'
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->teacher_id) {
                $exists = \App\Models\RoleAssignment::where('head_of_major_id', $model->teacher_id)
                    ->orWhere('program_coordinator_id', $model->teacher_id)
                    ->exists();

                if ($exists) {
                    throw new \Exception('Teacher is assigned as head/program coordinator and cannot be guardian.');
                }
            }
        });
    }
}
