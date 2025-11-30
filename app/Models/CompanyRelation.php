<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRelation extends Model
{
    //

    use HasFactory, HasUuids;

    protected $fillable = [
        'company_id',
        'major_id',
        'partnership_type',
        'status',
        'start_date',
        'end_date',
        'document_link',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }
}
