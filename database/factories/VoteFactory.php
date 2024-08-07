<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Vote::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'website_id' => \App\Models\Website::factory(),
        ];
    }
}
