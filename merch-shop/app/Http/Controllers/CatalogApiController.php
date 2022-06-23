<?php

namespace App\Http\Controllers;

use App\Http\Resources\CatalogResource;
use App\Models\ProductCategory;
use App\OpenApi\Responses\CatalogResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\ProductCategoryResponse;
use Illuminate\Contracts\Support\Responsable;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CatalogApiController extends Controller
{
    /**
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['catalog'], method: 'GET')]
    #[OpenApi\Response(factory: CatalogResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function index(): Responsable
    {
        return CatalogResource::collection(
            ProductCategory::query()->get(),
        );
    }

    /**
     * @param string $slug
     * @return CatalogResource
     */
    #[OpenApi\Operation(tags: ['catalog'], method: 'GET')]
    #[OpenApi\Response(factory: ProductCategoryResponse::class, statusCode: 200)]
    public function show(string $slug): CatalogResource
    {
        return new CatalogResource(
            ProductCategory::query()->where('slug', $slug)->firstOrFail()
        );
    }
}
