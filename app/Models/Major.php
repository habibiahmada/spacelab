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
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(Classroom::class, 'major_id');
    }

    public function roleAssignments()
    {
        return $this->hasMany(RoleAssignment::class, 'major_id');
    }
}