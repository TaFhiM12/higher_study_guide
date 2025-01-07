<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'website',
        'logo',
        'TIN',
        'bio',
        'phone',
        'address',
        'is_featured',
        'is_approved',
    ];

    /**
     * Relationship: Agency belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviews()
{
    return $this->hasMany(Review::class);
}

public function visaPacks()
{
    return $this->hasMany(VisaPack::class);
}
/**
 * Get all students associated with this agency.
 */
public function students()
{
    return $this->hasMany(Student::class);
}



}
