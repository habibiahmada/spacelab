<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'building';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'code', 'description', 'total_floors'];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'building_id');
    }
}
