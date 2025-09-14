<?php

namespace Database\Factories;

use App\Traits\RecipeData;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    use RecipeData;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement($this->mains).' '.
                        $this->faker->unique()->words(2, true).' by chef '.
                        $this->faker->firstName(),
            'description' => $this->faker->paragraph(2, true),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
