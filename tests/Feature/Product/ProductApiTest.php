<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use DatabaseTransactions;
    
    protected function setUp(): void
    {
        parent::setUp();
        //авторизация пользователя для запросов
        Sanctum::actingAs(User::factory()->create());
    }

    #[Test]
    public function can_create_new_product()
    {
        $productData = [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 99.99,
            'category_id' => 1
        ];

        // Act
        $response = $this->postJson('/api/products', $productData);

        // Assert
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'Test Product',
                    'price' => 99.99
                ]
            ]);

        $this->assertDatabaseHas('products', $productData);
    }

    #[Test]
    public function cannot_create_product_with_invalid_data()
    {
        // Act
        $response = $this->postJson('/api/products', [
            'name' => '',
            'price' => -10,
            'category_id' => 999
        ]);

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'price', 'category_id']);
    }

    #[Test]
    public function can_show_single_product()
    {
        $product = Product::find(1);
        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name
                ]
            ]);
    }

    #[Test]
    public function returns_404_for_non_existent_product()
    {
        $response = $this->getJson('/api/products/999999');

        $response->assertStatus(404);
    }

    #[Test]
    public function can_update_product()
    {
        $product = Product::factory()->create(['price' => 100]);
        $updateData = ['price' => 150];

        $response = $this->putJson("/api/products/{$product->id}", 
            array_merge($product->toArray(), $updateData)
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'price' => 150
        ]);
    }

    #[Test]
    public function can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(204);
        $this->assertNull(Product::find($product->id));
    }

    #[Test]
    public function unauthenticated_user_cannot_access_products()
    {
        $this->app->get('auth')->forgetGuards();

        $response = $this->deleteJson('/api/products/3');
        $response->assertStatus(401);
    }
}