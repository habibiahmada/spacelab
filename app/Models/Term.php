<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Term extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['tahun_ajaran', 'start_date', 'end_date', 'is_active', 'kind'];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function blocks()
    {
        return $this->hasMany(Block::class, 'terms_id');
    }
    
    public function timetableTemplates()
    {
        return $this->hasManyThrough(
            TimetableTemplate::class,
            Block::class,
            'terms_id',
            'block_id',
            'id',
            'id'
        );
    }
}
