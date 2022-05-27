<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResources;
use App\Http\Resources\ProductsFromCatalogResources;
use App\Models\Product;
use App\Models\ProductCategory;
use App\OpenApi\Parameters\ListProductParameters;
use App\OpenApi\Responses\ListProductResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\ShowProductResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class ProductApiController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    #[OpenApi\Operation(tags: ['product'], method: 'GET')]
    #[OpenApi\Response(factory: ListProductResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Parameters(factory: ListProductParameters::class)]
    public function index(Request $request): AnonymousResourceCollection
    {
        $slug = $request->query('category_slug');
        $query = ProductCategory::query()
            ->with('children', 'products');
        if (!$slug === null) {
            $query->where('slug', $slug);
        } else {
            $query->where('parent_id');
        }
        $categories = $query->get();
        $products = ProductCategory::getTreeProductsBuilder($categories)->orderBy('id')->paginate();


        return ProductsFromCatalogResources::collection($products);
    }

    /**
     * @param string $slug
     * @return ProductResources
     */
    #[OpenApi\Operation(tags: ['product'], method: 'GET')]
    #[OpenApi\Response(factory: ShowProductResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function show(string $slug):ProductResources
    {
        return new ProductResources(
            Product::query()
                ->with('productCategory', 'sortedAttributeValues.productAttribute')
                ->where('slug', $slug)
                ->firstOrFail()
        );
    }
}
