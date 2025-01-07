<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'agency_id',
        'rating',
        'details',
    ];

    /**
     * Relationship: Review belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Review belongs to an Agency.
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
