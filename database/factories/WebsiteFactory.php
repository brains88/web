<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Website>
 */
class WebsiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Website::class;

    public function definition()
    {
        return [
            'name' => $this->faker->domainName,
            'url' => $this->faker->url,
            'description' => $this->faker->paragraph,
        ];
    }
}
