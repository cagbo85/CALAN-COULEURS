<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence,
            'answer' => $this->faker->text(30),
            'actif' => true,
            'ordre' => $this->faker->numberBetween(1, 10),
            'created_by' => $this->faker->randomElement([1, 2, 3]),
            'updated_by' => $this->faker->randomElement([1, 2, 3]),
        ];
    }
}
