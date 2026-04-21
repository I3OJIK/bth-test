<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryApiController extends Controller
{
    public function __construct(
        private CategoryService $categoryService,
    )
    {}

    /**
     * Список всех категорий
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $categories = $this->categoryService->getAll();

        return CategoryResource::collection($categories);
    }
}
