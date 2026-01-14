<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MajorSubject extends Pivot
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'major_subject';

    protected $fillable = [
        'major_id',
        'subject_id',
        'notes',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
