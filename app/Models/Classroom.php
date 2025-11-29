<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Classroom extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'classes'; 

    protected $fillable = [
        'level',
        'major_id',
        'rombel',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function classHistories(): HasMany
    {
        return $this->hasMany(ClassHistory::class, 'class_id');
    }

    public function timetableTemplates(): HasMany
    {
        return $this->hasMany(TimetableTemplate::class, 'class_id');
    }

    public function timetableEntries(): HasManyThrough
    {
        return $this->hasManyThrough(
            TimetableEntry::class,
            TimetableTemplate::class,
            'class_id',
            'template_id',
            'id',
            'id'
        );
    }

    public function getFullNameAttribute()
    {
        return "{$this->level} {$this->major->code} {$this->rombel}";
    }
}