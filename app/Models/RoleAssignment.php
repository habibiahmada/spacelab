<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoleAssignment extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['major_id', 'head_of_major_id', 'program_coordinator_id', 'terms_id'];

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function head(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'head_of_major_id');
    }

    public function programCoordinator(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'program_coordinator_id');
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'terms_id');
    }
}
