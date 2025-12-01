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

    protected static function booted()
    {
        static::saving(function ($model) {
            // Check uniqueness constraints at application level as well.
            // Prevent a teacher from being head or program_coordinator in more than one major in the same term.
            $term = $model->terms_id;

            if ($model->head_of_major_id) {
                $conflict = RoleAssignment::where('terms_id', $term)
                                ->where(function ($q) use ($model) {
                                    $q->where('head_of_major_id', $model->head_of_major_id)
                                      ->orWhere('program_coordinator_id', $model->head_of_major_id);
                                })
                                ->where('id', '!=', $model->id ?? null)
                                ->exists();

                if ($conflict) {
                    throw new \Exception('Teacher already assigned as head or program coordinator in the same term.');
                }
            }

            if ($model->program_coordinator_id) {
                $conflict = RoleAssignment::where('terms_id', $term)
                                ->where(function ($q) use ($model) {
                                    $q->where('head_of_major_id', $model->program_coordinator_id)
                                      ->orWhere('program_coordinator_id', $model->program_coordinator_id);
                                })
                                ->where('id', '!=', $model->id ?? null)
                                ->exists();

                if ($conflict) {
                    throw new \Exception('Teacher already assigned as head or program coordinator in the same term.');
                }
            }
        });
    }
}
