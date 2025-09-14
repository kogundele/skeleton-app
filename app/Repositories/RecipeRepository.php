<?php
namespace App\Repositories;

use App\Filters\RecipeQueryFilter;
use App\Models\Recipe;
use App\Repositories\Contracts\RecipeRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeRepository implements RecipeRepositoryInterface
{    
    /**
     * getAllRecipes
     *
     * @param  mixed $searchParams
     * @param  mixed $perPage
     * @return LengthAwarePaginator
     */
    public function getAllRecipes(array $searchParams = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Recipe::with(['ingredients', 'steps']);
        $search = app(RecipeQueryFilter::class, ['searchParams' => $searchParams]);

        return $search->apply($query)->paginate($perPage);
    }
    
    /**
     * findBySlug
     *
     * @param  mixed $slug
     * @return Recipe
     */
    public function findBySlug(string $slug): ?Recipe
    {
        return Recipe::with(['ingredients', 'steps'])
                    ->where('slug', $slug)
                    ->firstOrFail();
    }
}