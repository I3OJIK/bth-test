<?php

namespace Tests\Unit\Services;

use App\Filters\Product\ProductFilter as ProductProductFilter;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    private ProductService $productService;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Создаем сервис 
        $productFilter = new ProductProductFilter();
        $this->productService = new ProductService($productFilter);
    }

    #[Test]
    public function can_get_paginated_products()
    {
        // создаем категорию
        $category = $this->createCategory();
        
        // Создаем 15 продуктов вручную
        for ($i = 1; $i <= 15; $i++) {
            $product = new Product();
            $product->name = "Product {$i}";
            $product->description = "Description {$i}";
            $product->price = 100 + $i;
            $product->category_id = $category->id;
            $product->save();
        }

        $result = $this->productService->getPaginatedProducts(10, []);

        $this->assertCount(10, $result->items());
        $this->assertEquals(15, $result->total());
    }

    #[Test]
    public function can_filter_products_by_category()
    {
        $category1 = $this->createCategory('Category 1');
        $category2 = $this->createCategory('Category 2');
        
        // Создаем 3 продукта в первой категории
        for ($i = 1; $i <= 3; $i++) {
            $product = new Product();
            $product->name = "Product {$i} in Cat1";
            $product->description = "Description";
            $product->price = 100;
            $product->category_id = $category1->id;
            $product->save();
        }
        
        // Создаем 2 продукта во второй категории
        for ($i = 1; $i <= 2; $i++) {
            $product = new Product();
            $product->name = "Product {$i} in Cat2";
            $product->description = "Description";
            $product->price = 100;
            $product->category_id = $category2->id;
            $product->save();
        }

        $result = $this->productService->getPaginatedProducts(10, ['category' => $category1->name]);
        $this->assertCount(3, $result->items());
    }

    #[Test]
    public function can_create_product()
    {
        //создаем категорию
        $category = $this->createCategory();
        
        $data = [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 99.99,
            'category_id' => $category->id
        ];

        $product = $this->productService->create($data);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Test Product', $product->name);
        $this->assertEquals(99.99, $product->price);
        
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 99.99
        ]);
    }

    #[Test]
    public function can_update_product()
    {
        // создаем категорию и продукт
        $category = $this->createCategory();
        
        $product = new Product();
        $product->name = 'Old Name';
        $product->description = 'Old Description';
        $product->price = 100;
        $product->category_id = $category->id;
        $product->save();
        
        $updateData = [
            'name' => 'Updated Name',
            'price' => 150
        ];

        $updatedProduct = $this->productService->update($product, $updateData);

        $this->assertEquals('Updated Name', $updatedProduct->name);
        $this->assertEquals(150, $updatedProduct->price);
        
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name',
            'price' => 150
        ]);
    }

    #[Test]
    public function can_delete_product()
    {
        // создаем категорию и продукт
        $category = $this->createCategory();
        
        $product = new Product();
        $product->name = 'Product to Delete';
        $product->description = 'Will be deleted';
        $product->price = 100;
        $product->category_id = $category->id;
        $product->save();

        $this->productService->delete($product);

        $this->assertNull(Product::find($product->id));
    }


    private function createCategory(string $name = 'Test Category'): Category
    {
        $category = new Category();
        $category->name = $name;
        $category->save();
        
        return $category;
    }
}