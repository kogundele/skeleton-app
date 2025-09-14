<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'email',
    ];
    
    /**
     * ingredients
     *
     * @return BelongsToMany
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredients');
    }
    
    /**
     * steps
     *
     * @return HasMany
     */
    public function steps(): HasMany
    {
         return $this->hasMany(RecipeStep::class)->orderBy('display_order', 'asc');
    }
    
    /**
     * boot
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($recipe) {
            $recipe->slug = static::generateSlug($recipe->name);
        });

        static::updating(function ($recipe) {
            if ($recipe->isDirty('name')) {
                $recipe->slug = static::generateSlug($recipe->name);
            }
        });
    }
    
    /**
     * generateSlug
     *
     * @param  mixed $name
     * @return string
     */
    protected static function generateSlug(string $name): string
    {
        $slug = Str::slug($name);

        $counter = static::where('slug', 'like', "{$slug}%")->count();
        return $counter ? "{$slug}-{$counter}" : $slug;
    }
}
