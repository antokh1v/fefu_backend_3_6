<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartModificationRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartApiController extends Controller
{
    /**
     * @return CartResource
     */
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
    public function setQuantity(CartModificationRequest $request): CartResource
    {
        $data = $request->validated('modifications');
        var_dump($request->validated());
        die;
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
