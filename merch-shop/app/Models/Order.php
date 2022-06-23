<?php

namespace App\Models;

use App\Enums\DeliveryType;
use App\Enums\PaymentMethod;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Order extends Model
{
    use HasFactory;

    public static function storeNewOrder($request, $data): self
    {
        $user = $request->user();

        $cart = Cart::getOrCreateCart($user, null);
        if($cart->isEmpty()) {
            throw new Exception('Cart is empty', 404);
        }

        $address = null;
        if (DeliveryType::keyToValue($data['delivery_type']) === DeliveryType::COURIER) {
            $address = Address::createFromRequest($data['delivery_address']);
        }

        $cart->user_id = null;
        $cart->session_id = null;
        $cart->save();

        $order = new Order();
        $order->user_id = $request->user()->id;
        $order->address_id = $address?->id;
        $order->cart_id = $cart->id;
        $order->customer_name = $data['customer_name'];
        $order->customer_email = $data['customer_email'];
        $order->delivery_type = DeliveryType::keyToValue($data['delivery_type']);
        $order->payment_method = PaymentMethod::keyToValue($data['payment_method']);
        $order->save();

        return $order;
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
