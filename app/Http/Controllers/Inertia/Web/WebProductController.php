<?php

namespace App\Http\Controllers\Inertia\Web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class WebProductController extends Controller
{

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
