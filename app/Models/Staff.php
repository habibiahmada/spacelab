<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Staff extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'staffs';

    protected $fillable = [
        'user_id',
        'type',
        'avatar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
