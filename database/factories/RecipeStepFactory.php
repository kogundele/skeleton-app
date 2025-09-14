<?php

namespace Database\Factories;

use App\Traits\RecipeData;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecipeStep>
 */
class RecipeStepFactory extends Factory
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
            'step' => $this->faker->randomElement($this->actions).' '.
                        $this->faker->numberBetween(1,5).' '.
                        $this->faker->randomElement($this->measuringUnits).' '.
                        $this->faker->randomElement($this->ingredients).' '.
                        $this->faker->words(5, true),
            'display_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
