<?php

namespace App\Http\Controllers\Inertia\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFilterRequest;
use App\Models\Product;
use App\Services\ProductService;
use Inertia\Inertia;

class WebProductController extends Controller
{
    public function __construct(
        private ProductService $productService
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

        return Inertia::render('Home', [
            'products' => $products,
            'filters' => $request->filters(),
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
