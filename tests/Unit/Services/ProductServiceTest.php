<?php

namespace Tests\Unit\Services;

use App\Filters\Product\ProductFilter as ProductProductFilter;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use DatabaseTransactions;

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
        Product::factory()->count(15)->create();

        $result = $this->productService->getPaginatedProducts(10, []);

        $this->assertCount(10, $result->items());
    }

    #[Test]
    public function can_filter_products_by_category()
    {
        $category1 = Category::factory()->create(['name' => 'Electronics']);
        $category2 = Category::factory()->create(['name' => 'Books']);
        
        Product::factory()->count(3)->create(['category_id' => $category1->id]);
        Product::factory()->count(2)->create(['category_id' => $category2->id]);

        $result = $this->productService->getPaginatedProducts(10, ['category' => $category1->name]);
        $this->assertCount(3, $result->items());
    }

    #[Test]
    public function can_create_product()
    {
        //создаем категорию
        $category =  Category::factory()->create();
        
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
        $product = Product::factory()->create([
            'name' => 'Old Name',
            'price' => 100
        ]);
        
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
        $product = Product::factory()->create();

        $this->productService->delete($product);

        $this->assertNull(Product::find($product->id));
    }
}