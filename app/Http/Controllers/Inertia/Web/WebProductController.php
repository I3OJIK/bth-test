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
    public function index(ProductFilterRequest $request)
    {
        $products = $this->productService->getPaginatedProducts(
            $request->perPage(),
            $request->filters()
        );

        $categories = $this->categoryService->getAll();

        return Inertia::render('Home', [
            'products' => $products,
            'filters' => $request->filters(),
            'categories' => $categories,
        ]);
    }

    /**
     * Карточка товара
     */
    public function show(Product $product)
    {
        return Inertia::render('ProductShow', [
            'product' => $product,
        ]);
    }
}
