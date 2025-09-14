<?php
namespace App\Repositories\Contracts;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface RecipeRepositoryInterface
{
        
    /**
     * Get all recipes
     *
     * @return Collection
     */
    public function getAllRecipes(array $searchParams = [], int $perPage = 10): LengthAwarePaginator;

        
    /**
     * Find recipe by slug
     *
     * @param  mixed $slug
     * @return Recipe
     */
    public function findBySlug(string $slug): ?Recipe;
}