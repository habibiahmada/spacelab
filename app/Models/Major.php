<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Major extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'code',
        'name',
        'description',
        'head_of_major_id',
        'program_coordinator_id',
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(ClassRoom::class, 'major_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'major_id');
    }

    public function headOfMajor(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'head_of_major_id');
    }

    public function programCoordinator(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'program_coordinator_id');
    }
}