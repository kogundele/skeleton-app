<?php
namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Repositories\Contracts\RecipeRepositoryInterface;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function __construct(private RecipeRepositoryInterface $recipe)
    {
        
    }

    public function index(Request $request)
    {
        $searchParams = $request->only(['email', 'ingredient', 'keyword']);

        $recipes = $this->recipe->getAllRecipes($searchParams);

        return RecipeResource::collection($recipes);
    }

    public function show($slug)
    {
        $recipe = $this->recipe->findBySlug($slug);

        return new RecipeResource($recipe);
    }
}