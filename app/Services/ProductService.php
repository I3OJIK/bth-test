<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{

    /**
     * Пагинированный список товаров
     * 
     * @param int $perPage
     * @param int|null $categoryId
     * 
     * @return LengthAwarePaginator
     */
    public function getPaginatedProducts(
        int $perPage = 15,
        ?int $categoryId = null
    ): LengthAwarePaginator {
        return Product::query()
            ->with('category')
            ->when(
                $categoryId,
                fn($q) =>
                $q->where('category_id', $categoryId)
            )
            ->paginate($perPage);
    }

    /**
     * Получить товар по ID
     * 
     * @param int $id
     * 
     * @return Product
     */
    public function getProduct(int $id): Product
    {
        return Product::with('category')->findOrFail($id);
    }

    /**
     * Создать товар
     * 
     * @param array $data
     * 
     * @return Product
     */
    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * Обновить товар
     * 
     * @param Product $product
     * @param array $data
     * 
     * @return Product
     */
    public function updateProduct(Product $product, array $data): Product
    {
        $product->update($data);

        return $product;
    }

    /**
     * Удалить товар
     * 
     * @param Product $product
     * 
     * @return void
     */
    public function deleteProduct(Product $product): void
    {
        $product->delete();
    }
}
