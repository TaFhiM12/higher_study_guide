<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaPack extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agency_id',
        'status',
        'country_name',
        'degree',
        'processing_time',
        'cost',
        'details',
        'image',
        'is_approved',
        'is_featured',
        'expire_date',
        'title'
    ];

    /**
     * Relationship: VisaPack belongs to an Agency.
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
