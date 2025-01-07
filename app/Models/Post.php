<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',       // Foreign key for the user who created the post
        'title',         // Post title
        'image',         // Path to the post image
        'country_name',  // Country associated with the post
        'degree_type',   // Degree type (Undergraduate, Masters, PhD)
        'post_content',       // Post content
        'publishers',    // Publishers' name
        'is_approved',   // Approval status
    ];

    /**
     * Relationship: Post belongs to a User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
