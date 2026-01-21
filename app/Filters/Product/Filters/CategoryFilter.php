<?php

namespace App\Filters\Product\Filters;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter
{
    /**
     * Сортировка по категории
     * 
     * @param Builder $query
     * @param string $categoryName
     * 
     * @return Builder
     */
    public function apply(Builder $query, string $categoryName): Builder
    {
        $categoryId = Category::where('name', $categoryName)->firstOrFail()->id; // сортировка по имени категории

        $query = $query->where('category_id', $categoryId);
        return $query;
    }
}