<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    )
    {}

    /**
     * Список всех товаров с пагинацией
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $products = $this->productService->getPaginatedProducts(15);

        return ProductResource::collection($products);
    }


    /**
     * Создание нового товара
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request): JsonResponse
    {
        $data = $request->validated();

        $product = $this->productService->createProduct($data);

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Просмотр одного товара
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product): ProductResource
    {
        $product = $this->productService->getProduct($product->id);

        return new ProductResource($product);
    }

    /**
     * Обновление существующего товара
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return ProductResource
     */
    public function update(ProductRequest $request, Product $product): ProductResource
    {
        $data = $request->validated();

        $product = $this->productService->updateProduct($product, $data);

        return new ProductResource($product);
    }

    /**
     * Удаление товара
     *
     * @param Product $product
     * @return Response
     */
    public function destroy(Product $product): Response
    {
        $this->productService->deleteProduct($product);

        return response()->noContent();
    }
}
