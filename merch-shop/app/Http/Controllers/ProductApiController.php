<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatalogFormRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsFromCatalogResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\OpenApi\Parameters\ListProductParameters;
use App\OpenApi\Responses\ListProductResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\ShowProductResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class ProductApiController extends Controller
{
    /**
     * @param CatalogFormRequest $request
     * @return AnonymousResourceCollection
     */
    #[OpenApi\Operation(tags: ['product'], method: 'GET')]
    #[OpenApi\Response(factory: ListProductResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Parameters(factory: ListProductParameters::class)]
    public function index(CatalogFormRequest $request): mixed
    {
        $requestData = $request->validated();


        $requestData['slug'] = $requestData['category_slug'] ?? null;
        try {
            $data = Product::findProducts($requestData);
        } catch (Throwable $e) {
            abort(422, $e->getMessage());
        }
        return ProductsFromCatalogResource::collection(
            $data['product_query']->orderBy('products.id')->paginate()->appends([
                'category_slug' => $data['key_params']['category_slug'],
                'search_query' => $data['key_params']['search_query'],
                'filters' => $data['key_params']['filters'],
                'sort_mode' => $data['key_params']['sort_mode']
            ])
        )->additional($data['filters']);
    }

    /**
     * @param string $slug
     * @return ProductResource
     */
    #[OpenApi\Operation(tags: ['product'], method: 'GET')]
    #[OpenApi\Response(factory: ShowProductResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function show(string $slug): ProductResource
    {
        return new ProductResource(
            Product::query()
                ->with('productCategory', 'sortedAttributeValues.productAttribute')
                ->where('slug', $slug)
                ->firstOrFail()
        );
    }
}
