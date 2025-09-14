<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\RecipeStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Generating Recipes with ingredients and steps');

        $ingredients = Ingredient::factory()->count(100)->create();

        Recipe::factory()
            ->count(1000)
            ->create()
            ->each(function ($recipe) use ($ingredients) {
                // Attach ingredients to recipe
                $recipeIngredients = $ingredients->random(rand(10, 20))->pluck('id')->toArray();
                $recipe->ingredients()->attach($recipeIngredients);

                // Add steps
                RecipeStep::factory()
                    ->count(rand(4, 8))
                    ->make()
                    ->each(function ($step, $index) use ($recipe) {
                        $step->display_order = $index++;
                        $step->recipe_id = $recipe->id;
                        $step->save();
                    });
            });
        
        $this->command->info('Seeding recipes completed!');
    }
}
