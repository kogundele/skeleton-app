<?php
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;


class RecipeQueryFilter
{
    public function __construct(protected array $searchParams = [])
    {
        
    }
    
    /**
     * apply
     *
     * @param  mixed $query
     * @return Builder
     */
    public function apply(Builder $query): Builder
    {
        return $query->when(!empty($this->searchParams['email'])
                && filter_var($this->searchParams['email'], FILTER_VALIDATE_EMAIL), fn($q) => 
                $q->where('email', $this->searchParams['email'])
            )
            ->when(!empty($this->searchParams['ingredient']), fn($q) => 
                $q->whereHas('ingredients', fn($iq) => 
                    $iq->where('name', 'like', '%'.$this->searchParams['ingredient'].'%')
                )
            )
            ->when(!empty($this->searchParams['keyword']), fn($q) => 
                $q->where(function($sq) {
                    $sq->whereFullText(['name', 'description'], $this->searchParams['keyword'])
                    ->orWhereHas('ingredients', fn($iq) => 
                            $iq->where('name', 'like', '%'.$this->searchParams['keyword'].'%')
                    )
                    ->orWhereHas('steps', fn($sq) => 
                            $sq->where('step', 'like', '%'.$this->searchParams['keyword'].'%')
                    );
                })
            );
    }
}