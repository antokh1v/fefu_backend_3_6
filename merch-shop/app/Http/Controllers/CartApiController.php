<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartModificationRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\OpenApi\RequestBodies\CartModRequestBody;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\ShowCartResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CartApiController extends Controller
{
    /**
     * @return CartResource
     */
    #[OpenApi\Operation(tags: ['cart'], method: 'GET')]
    #[OpenApi\Response(factory: ShowCartResponse::class, statusCode: 200)]
    public function show(): CartResource
    {
        $user = Auth::user();
        $sessionId = session()->getId();
        $cart = Cart::getOrCreateCart($user, $sessionId);
        return CartResource::make($cart);
    }
    /**
     * Handle the incoming request.
     *
     * @param CartModificationRequest $request
     * @return CartResource
     */
    #[OpenApi\Operation(tags: ['cart'], method: 'POST')]
    #[OpenApi\Response(factory: ShowCartResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\RequestBody(factory: CartModRequestBody::class)]
    public function setQuantity(CartModificationRequest $request): CartResource
    {
        $data = $request->validated('modifications');
        $user = Auth::user();
        $sessionId = session()->getId();
        $cart = Cart::getOrCreateCart($user, $sessionId);

        $productIds = array_column($data, 'product_id');
        $productsById = Product::whereIn($productIds)->get()->keyBy('id');
        foreach ($data as $modification)
        {
            $cart->setProductQuantity($productsById[$modification['product_id']], $modification['quantity']);
        }
        $cart->recalculateCart();
        $cart->save();

        return new CartResource($cart);
    }
}
