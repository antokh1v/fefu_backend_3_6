<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;
    /** @var CartItem[] */
    private $itemsByProductId;

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderedItems(): HasMany
    {
        return $this->items()->orderBy('id');
    }

    /**
     * @throws Exception
     */
    public static function getCart(?User $user, ?string $sessionId): ?Cart
    {
        if ($user === null && $sessionId === null)
        {
            throw new Exception('User or sessionId is empty');
        }
        $query = self::query();
        if ($user !== null){
            $query->where('user_id', $user->id);
        }
        if ($sessionId !== null){
            $query->where('session_id', $sessionId);
        }
        return $query->first();
    }

    public static function createEmptyCart(?User $user, ?string $sessionId):Cart
    {
        $cart = new self();
        $cart->user_id = $user->id ?? null;
        $cart->session_id = $sessionId;
        $cart->price_total = 0;
        return $cart;
    }

    public static function getOrCreateCart(?User $user, ?string $sessionId):Cart
    {
        return self::getCart($user, $sessionId) ?? self::createEmptyCart($user, $sessionId);
    }

    private function fillCartItemsByProductId() : void
    {
        if ($this->itemsByProductId === null)
        {
            $this->load('items.product');
            $this->itemsByProductId = [];
            foreach ($this->items as $cartItem){
                $this->itemsByProductId[$cartItem->product_id] = $cartItem;
            }
        }
    }

    public function setProductQuantity(Product $product, int $quantity): void
    {
        $this->fillCartItemsByProductId();

        $cartItem = $this->itemsByProductId[$product->id] ?? null;
        if ($cartItem === null){
            $cartItem = new CartItem();
            $cartItem->product_id = $product->id;
        }
        $cartItem->price_item = $product->price;
        $cartItem->quantity = $quantity;
        $cartItem->price_total = $cartItem->price_item * $quantity;

        $this->itemsByProductId[$product->id] = $cartItem;
    }

    public function recalculateCart():void
    {
        $this->fillCartItemsByProductId();

        $this->price_total = 0;
        foreach ($this->itemsByProductId as $productId => $cartItem)
        {
            $cartItem->price_item = $cartItem->product->price;
            $cartItem->price_total = $cartItem->price_item * $cartItem->quantity;
            $this->price_total+=$cartItem->price_total;
        }
    }

    public function save(array $options = []): void
    {
        parent::save($options);
        if ($this->itemsByProductId !== null){
            foreach ($this->itemsByProductId as $productId => $cartItem){
                 $cartItem->cart_id = $this->id;
                 $cartItem->save();

                 if ($cartItem->quantity === 0)
                 {
                     $cartItem->delete();
                     unset($this->itemsByProductId[$productId]);
                 }
            }
        }
    }

    public function isEmpty(): bool
    {
        $this->fillCartItemsByProductId();

        return count($this->itemsByProductId) === 0;
    }
}
