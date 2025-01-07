<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * User roles constants.
     */
    const ROLE_STUDENT = 'student';
    const ROLE_AGENCY = 'agency';
    const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',       // User's name
        'email',      // User's email
        'role',       // User's role (student, agency, admin)
        'password',   // Encrypted password
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if the user is a student.
     *
     * @return bool
     */
    public function isStudent()
    {
        return $this->role === self::ROLE_STUDENT;
    }

    /**
     * Check if the user is an agency.
     *
     * @return bool
     */
    public function isAgency()
    {
        return $this->role === self::ROLE_AGENCY;
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Relationship to posts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function agency()
    {
        return $this->hasOne(Agency::class);
    }
    public function reviews()
{
    return $this->hasMany(Review::class);
}

}
