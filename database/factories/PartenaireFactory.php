<?php
namespace Database\Factories;

use App\Models\Partenaire;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartenaireFactory extends Factory
{
    protected $model = Partenaire::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->sentence,
            'logo' => null,
            'photo' => null,
            'site_url' => $this->faker->optional()->url,
            'instagram_url' => $this->faker->optional()->url,
            'facebook_url' => $this->faker->optional()->url,
            'linkedin_url' => $this->faker->optional()->url,
            'autre_url' => $this->faker->optional()->url,
            'phone' => $this->faker->optional()->phoneNumber,
            'adresse' => $this->faker->optional()->streetAddress,
            'ville' => $this->faker->optional()->city,
            'departement' => $this->faker->optional()->state,
            'code_postal' => $this->faker->optional()->postcode,
            'pays' => $this->faker->optional()->country,
            'latitude' => $this->faker->optional()->latitude,
            'longitude' => $this->faker->optional()->longitude,
            'actif' => true,
            'ordre' => $this->faker->numberBetween(1, 20),
            'annee' => 2025,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
};
