<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'link' => $this->faker->url(),
            'title' => $this->faker->sentence(),
            'postby' => \App\Models\User::factory(),
            'catagory' => $this->faker->randomElement([
                'marketplace',
                'chat room',
                'forums',
                'service',
                'search',
                'directory link',
                'youtube',
                'uploader',
                'other'
            ]),
        ];
    }
}
