<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Using the rinvex/countries package to get a random country name
        $countries = countries(); // Fetch all countries
        $randomCountryKey = array_rand($countries); // Get a random country key
        $randomCountry = $countries[$randomCountryKey]['name']; // Get the country name

        return [
            'user_id' => User::factory(), // Create a new user and associate it with the post
            'title' => $this->faker->sentence, // Generate a random title
            'image' => 'https://placehold.co/600x400', // Use the provided placeholder image
            'country_name' => $randomCountry, // Assign a random country name
            'degree_type' => $this->faker->randomElement(['Undergraduate', 'Masters', 'PhD']), // Random degree type
            'content' => $this->faker->paragraphs(3, true), // Generate 3 paragraphs of content
            'publishers' => $this->faker->company, // Generate a random publisher name
            'is_approved' => $this->faker->boolean(50), // Randomly approve/disapprove the post
        ];
    }
}
