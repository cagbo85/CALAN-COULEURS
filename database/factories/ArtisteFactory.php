<?php

namespace Database\Factories;

use App\Models\Artiste;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtisteFactory extends Factory
{
    protected $model = Artiste::class;

    public function definition()
    {
        $beginDate = $this->faker->dateTimeBetween('2025-09-12 15:00:00', '2025-09-13 23:00:00');
        $endDate = (clone $beginDate)->modify('+90 minutes');

        return [
            'name' => $this->faker->words(2, true),
            'style' => $this->faker->randomElement(['Rock', 'Electronic', 'Hip-hop', 'Jazz', 'Pop', 'Reggae']),
            'description' => $this->faker->paragraph(2),
            'photo' => 'img/artists/photos/Photos_artistes/ROCK 109.webp',
            'begin_date' => $beginDate,
            'ending_date' => $endDate,
            'scene' => $this->faker->randomElement(['Intérieur', 'Extérieur']),
            'actif' => true,
            'created_by' => 1,
            'updated_by' => 1,
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
