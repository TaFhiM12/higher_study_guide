<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',          // Foreign key linking to the User model
        'academic',         // Academic details (array: exam_name, institution, result, scale, passing_year)
        'language',         // Language proficiency details (array: type, score, scale)
        'image',            // Profile image
        'fund',             // Available funds
        'study_interest',   // Field of study the student is interested in
        'eligibility',      // Boolean flag for higher study eligibility
        'pride', // New column
    'agency_id', // New column
    'current_institution', // New column
    'country', // New column
    ];

    protected $casts = [
        'academic' => 'array',
        'language' => 'array',
        'eligibility' => 'boolean',
    ];

    /**
     * Belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate and assess eligibility for higher study.
     */
    public function assessEligibility()
    {
        // Example logic to determine eligibility
        $eligible = true;

        // Check if academic details exist and are satisfactory
        if (!is_array($this->academic) || count($this->academic) === 0) {
            $eligible = false;
        }

        // Check if language proficiency exists and is satisfactory
        if ($this->language && isset($this->language['score']) && $this->language['score'] < 5) {
            $eligible = false;
        }

        // Check if funds are sufficient (e.g., minimum $10,000)
        if ($this->fund < 10000) {
            $eligible = false;
        }

        $this->eligibility = $eligible;
        $this->save();

        return $eligible;
    }

    /**
     * Suggest countries for higher study based on eligibility and fund.
     */
    public function suggestCountries()
    {
        $countries = [];

        if (!$this->eligibility) {
            return ['message' => 'Not eligible for higher studies.'];
        }

        // Example logic for country suggestion
        if ($this->fund >= 30000) {
            $countries = ['USA', 'UK', 'Canada', 'Australia'];
        } elseif ($this->fund >= 20000) {
            $countries = ['Germany', 'Netherlands', 'France'];
        } elseif ($this->fund >= 10000) {
            $countries = ['India', 'Malaysia', 'Turkey'];
        }

        return $countries;
    }
    

}
