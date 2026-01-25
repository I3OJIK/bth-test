<?php

namespace App\Http\Controllers\Inertia\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFilterRequest;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use Inertia\Inertia;

class WebProductController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService,
    )
    {}

    /**
     * Главная страница: список товаров с пагинацией и фильтром
     */
    public function index()
    {
        return Inertia::render('Home');
    }

    /**
     * Карточка товара
     */
    public function show($id)
    {
        return Inertia::render('Product/Show', [
            'productId' => (int) $id,
        ]);
    }
}
