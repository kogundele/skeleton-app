<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'email' => $this->email,
            'ingredients' => $this->ingredients->pluck('name'),
            'steps' => $this->steps->sortBy('display_order')->pluck('step'),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
