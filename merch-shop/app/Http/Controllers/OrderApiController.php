<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\OpenApi\Parameters\OrderParameters;
use App\OpenApi\RequestBodies\OrderRequestBody;
use App\OpenApi\Responses\CreateOrderResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class OrderApiController extends Controller
{
    /**
     * Create and return an order
     *
     * @param StoreOrderRequest $request
     * @return OrderResource|JsonResponse
     */
    #[OpenApi\Operation(tags: ['order'], security: BearerTokenSecurityScheme::class, method: 'POST')]
    #[OpenApi\RequestBody(factory: OrderRequestBody::class)]
    #[OpenApi\Parameters(factory: OrderParameters::class)]
    #[OpenApi\Response(factory: CreateOrderResponse::class, statusCode: 200)]
    public function store(StoreOrderRequest $request): JsonResponse|OrderResource
    {
        $data = $request->validated();
        try {
            $order = Order::storeNewOrder($request, $data);
        } catch (\Throwable $e) {
            return response()->json(['errors' => ['' => $e->getMessage()]], 422);
        }

        return OrderResource::make($order);
    }
}
