<?php

namespace App\Http\Controllers\inertia\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFilterRequest;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\CategoryService;
use Inertia\Inertia;

class AdminProductController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService,
    )
    {}

    /**
     * Список товаров для администратора
     */
    public function index(ProductFilterRequest $request)
    {

        return Inertia::render('Admin/Products/Index');
    }

    /**
     * Форма создания товара
     */
    public function create()
    {
        $categories = $this->categoryService->getAll();

        return Inertia::render('Admin/ProductForm', [
            'categories' => $categories,
        ]);
    }

    /**
     * Форма редактирования товара
     */
    public function edit(Product $product)
    {
        $categories = $this->categoryService->getAll();

        return Inertia::render('Admin/ProductForm', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }
}
