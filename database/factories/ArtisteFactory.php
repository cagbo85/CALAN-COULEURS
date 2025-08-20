<?php

namespace Database\Factories;

use App\Models\Artiste;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtisteFactory extends Factory
{
    protected $model = Artiste::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'style' => $this->faker->randomElement(['Rock', 'Electronic', 'Hip-hop', 'Jazz', 'Pop', 'Reggae']),
            'description' => $this->faker->paragraph(2),
            'photo' => 'img/artists/photos/Photos_artistes/ROCK 109.webp',
            'day' => 'Samedi',
            'begin_date' => now(),
            'ending_date' => now()->addHour(),
            'scene' => $this->faker->randomElement(['Intérieur', 'Extérieur']),
            'soundcloud_url' => null,
            'spotify_url' => null,
            'youtube_url' => null,
            'deezer_url' => null,
            'actif' => true,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the artist is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'actif' => false,
        ]);
    }

    /**
     * Create an artist for a specific scene.
     */
    public function scene(string $scene): static
    {
        return $this->state(fn(array $attributes) => [
            'scene' => $scene,
        ]);
    }
}
