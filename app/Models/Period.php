<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Period extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['ordinal', 'start_time', 'end_time', 'is_teaching', 'start_date', 'end_date'];

    protected $casts = [
        'start_time' => 'string',
        'end_time' => 'string',
    ];

    public function timetableEntries(): HasMany
    {
        return $this->hasMany(TimetableEntry::class, 'period_id');
    }


    public function isOngoing(?Carbon $now = null): bool
    {
        $now = $now ?? Carbon::now();
        if ($this->start_time && $this->end_time) {
            $startTime = Carbon::createFromFormat('H:i:s', $this->start_time, $now->getTimezone())->setDate($now->year, $now->month, $now->day);
            $endTime = Carbon::createFromFormat('H:i:s', $this->end_time, $now->getTimezone())->setDate($now->year, $now->month, $now->day);

            if ($endTime->lessThanOrEqualTo($startTime)) {
                $endTime->addDay();
                $startPrevious = $startTime->copy()->subDay();
                $endPrevious = $endTime->copy()->subDay();

                if ($now->between($startPrevious, $endPrevious) || $now->between($startTime, $endTime)) {
                    return true;
                }

                return false;
            }

            return $now->greaterThanOrEqualTo($startTime) && $now->lessThan($endTime);
        }

        if (! $this->start_date || ! $this->end_date) {
            return false;
        }

        return $now->greaterThanOrEqualTo($this->start_date) && $now->lessThan($this->end_date);
    }

    public function isPast(?Carbon $now = null): bool
    {
        $now = $now ?? Carbon::now();

        if ($this->end_time) {
            $startTime = null;
            if ($this->start_time) {
                $startTime = Carbon::createFromFormat('H:i:s', $this->start_time, $now->getTimezone())->setDate($now->year, $now->month, $now->day);
            }

            $endTime = Carbon::createFromFormat('H:i:s', $this->end_time, $now->getTimezone())->setDate($now->year, $now->month, $now->day);
            if ($startTime && $endTime->lessThanOrEqualTo($startTime)) {
                $endTime->addDay();
            }

            return $now->greaterThanOrEqualTo($endTime);
        }

        if (! $this->end_date) {
            return false;
        }

        return $now->greaterThanOrEqualTo($this->end_date);
    }
}
