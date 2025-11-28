<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Period extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['ordinal', 'start_date'];

    protected $casts = ['start_date' => 'datetime'];

    public function timetableEntries(): HasMany
    {
        return $this->hasMany(TimetableEntry::class, 'period_id');
    }
}
