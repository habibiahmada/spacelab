<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SubjectMajorAllowed extends Model
{
    use HasUuids;

    protected $table = 'subject_major_allowed';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'subject_id',
        'major_id',
        'reason',
        'is_allowed',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }
}
