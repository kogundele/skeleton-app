<?php

namespace Database\Factories;

use App\Traits\RecipeData;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
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
            'name' => $this->faker->numberBetween(1, 10).' '.
                        $this->faker->randomElement($this->measuringUnits).' '.
                        $this->faker->randomElement($this->ingredients),
        ];
    }
}
