<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['name'];
    // Previously we had a 'permissions' jsonb column; it was removed by migrations.

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function getLowerNameAttribute()
    {
        return strtolower($this->name);
    }
}