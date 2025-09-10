<?php

namespace Database\Factories;

use App\Models\Stand;
use Illuminate\Database\Eloquent\Factories\Factory;

class StandFactory extends Factory
{
    protected $model = Stand::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->sentence,
            'type' => $this->faker->randomElement(['boutique', 'foodtruck', 'tatouage', 'autre']),
            'instagram_url' => $this->faker->optional()->url,
            'facebook_url' => $this->faker->optional()->url,
            'website_url' => $this->faker->optional()->url,
            'other_link' => $this->faker->optional()->url,
            'actif' => true,
            'ordre' => $this->faker->numberBetween(1, 10),
            'year' => 2025,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
