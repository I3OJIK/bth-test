<?php

namespace App\Services;

use App\Filters\Product\ProductFilter;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function __construct(
        private ProductFilter $filter
    )
    {}

    /**
     * Пагинированный список товаров с возможностью фильтрации
     * 
     * @param int $perPage
     * @param int|null $categoryId
     * 
     * @return LengthAwarePaginator
     */
    public function getPaginatedProducts(
        array $filters = [],
        int $perPage = 15
    ): LengthAwarePaginator {
        $query = Product::query()
            ->with('category');

        $query = $this->filter->apply($query, $filters);

        return $query->paginate($perPage);
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
