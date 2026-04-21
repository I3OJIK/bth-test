<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductRequestTest extends TestCase
{
    #[Test]
    public function validates_required_fields()
    {
        $request = new ProductRequest();
        $validator = Validator::make([], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
        $this->assertArrayHasKey('price', $validator->errors()->toArray());
        $this->assertArrayHasKey('category_id', $validator->errors()->toArray());
    }

    #[Test]
    public function validates_price_is_numeric_and_positive()
    {
        $request = new ProductRequest();
        
        $validator = Validator::make(['price' => -10], $request->rules());
        $this->assertArrayHasKey('price', $validator->errors()->toArray());
        
        $validator = Validator::make(['price' => 'abc'], $request->rules());
        $this->assertArrayHasKey('price', $validator->errors()->toArray());
        
        $validator = Validator::make(['price' => 111], $request->rules());
        $this->assertArrayNotHasKey('price', $validator->errors()->toArray());
    }

   
}