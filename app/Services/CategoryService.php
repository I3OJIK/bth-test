<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    /**
     * Получить все категории
     * 
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Category::all();
    }

    /**
     * Получить категорию по ID
     * 
     * @param int $id
     * 
     * @return Category
     */
    public function getById(int $id): Category
    {
        return Category::findOrFail($id);
    }

}
