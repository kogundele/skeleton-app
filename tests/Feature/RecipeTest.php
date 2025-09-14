<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Recipe;
use App\Models\Ingredient;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    private $potato;
    private $scallop;
    private $recipe1;

    public function setUp(): void
    {
        parent::setUp();

        // Create ingredients
        $this->potato = Ingredient::factory()->create(['name' => 'potato']);
        $this->scallop = Ingredient::factory()->create(['name' => 'scallop']);

        // Create recipes
        $this->recipe1 = Recipe::factory()->create([
            'name' => 'Potato Scallop Delight',
            'description' => 'Delicious potato & scallop recipe',
            'email' => 'foo@bar.com',
        ]);
        $this->recipe1->ingredients()->attach([$this->potato->id, $this->scallop->id]);
    }

    public function testSearchByEmail()
    {
        $response = $this->getJson('/api/recipes', [
            'email' => 'foo@bar.com',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $this->recipe1->id]);
    }

    public function testSearchByIngredient()
    {
        $response = $this->getJson('/api/recipes', [
            'ingredient' => 'potato',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $this->recipe1->id]);
    }

    public function testSearchByKeyword()
    {
        $response = $this->getJson('/api/recipes', [
            'keyword' => 'scallop',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $this->recipe1->id]);
    }

    public function testSearchByCombination()
    {
        $response = $this->getJson('/api/recipes', [
            'email' => 'foo@bar.com',
            'ingredient' => 'potato',
            'keyword' => 'scallop',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $this->recipe1->id]);
    }

    public function testPaginatedResult()
    {
        Recipe::factory()->count(15)->create();

        $response = $this->getJson('/api/recipes');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'links',
                     'meta'
                 ]);
    }

    public function testShowRecipeBySlug()
    {
        $slug = $this->recipe1->slug;

        $response = $this->getJson("/api/recipes/{$slug}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => $this->recipe1->id,
                     'name' => $this->recipe1->name,
                     'slug' => $slug,
                     'description' => $this->recipe1->description,
                     'email' => $this->recipe1->email,
                 ]);
    }

    public function testRecipeSlugNotFound()
    {
        $nonExistentSlug = (Factory::class)::create()->slug();

        $response = $this->getJson("/api/recipes/{$nonExistentSlug}");

        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'No query results for model [App\\Models\\Recipe].',
                 ]);
    }
}