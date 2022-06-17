<?php

namespace App\Http\Controllers;

use App\Http\Resources\PageResource;
use App\Models\Page;
use App\OpenApi\Responses\ListPageResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\ShowPageResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class PageApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ["page"])]
    #[OpenApi\Response(factory: ListPageResponse::class, statusCode: 200)]
    public function index()
    {
        return PageResource::collection(
            Page::query()->paginate(5)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ["page"])]
    #[OpenApi\Response(factory: ShowPageResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function show(string $slug)
    {
        return New PageResource(
            Page::query()->where('slug',$slug)->firstOrFail()
        );
    }


}
