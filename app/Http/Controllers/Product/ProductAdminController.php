<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFilterRequest;
use Inertia\Inertia;

class ProductAdminController extends Controller
{
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
        return Inertia::render('Admin/Products/Create');
    }

    /**
     * Форма редактирования товара
     */
    public function edit($id)
    {
        return Inertia::render('Admin/Products/Edit', [
            'productId' => (int) $id,
        ]);
    }
}
