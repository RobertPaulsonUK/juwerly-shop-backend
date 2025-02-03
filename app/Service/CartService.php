<?php

    namespace App\Service;

    use App\Models\Cart;
    use App\Models\Product;
    use App\Models\Variation;
    use Carbon\Carbon;
    use Exception;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Validation\ValidationException;

    class CartService
    {
        public function addItem(array $data)
        {
            try {
                DB::beginTransaction();
                $cart = self::getOrCreateCart($data['quest_token'] ?? null);
                if(isset($data['quest_token'])) {
                    unset($data['quest_token']);
                }
                $checkAvailability = $this->checkProductAvailability($data['product_id'],$data['variation_id'] ?? null);
                if (!$checkAvailability) {
                    abort(404,'Product is not available or is out of stock.');
                }
                $cartItem = $cart->cartItems()->where('product_id', $data['product_id'])
                                 ->where('variation_id', $data['variation_id'] ?? null)
                                 ->first();

                if ($cartItem) {
                    $cartItem->increment('quantity', $data['quantity']);
                } else {
                    $cart->cartItems()->create([
                        'product_id' => $data['product_id'],
                        'variation_id' => $data['variation_id'] ?? null,
                        'quantity' => $data['quantity'],
                    ]);
                }
                $cart->updateCartPrice();
                $cart->update(['last_updated_at' => Carbon::now()]);
                $cart->fresh();
                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();
                abort(404,$exception);
            }
            return $cart;
        }
        public function updateItem(array $data)
        {
            try {
                DB::beginTransaction();
                $cart = self::getOrCreateCart($data['quest_token'] ?? null);
                $cartItem = $cart->cartItems()
                                 ->where('id','=',$data['cart_item_id'])
                                 ->first();
                if (!$cartItem) {
                    abort(404,'Provided cart item id is not correct');
                }
                if($data['quantity'] === 0) {
                    $cartItem->delete();
                } else {
                    $checkAvailability = $this->checkProductAvailability($cartItem->product_id,$cartItem->variation_id);
                    if (!$checkAvailability) {
                        abort(404,'Product is not available or is out of stock.');
                    }
                    $cartItem->update(['quantity' => $data['quantity']]);
                }
                $cart->updateCartPrice();
                $cart->update(['last_updated_at' => Carbon::now()]);
                $cart->fresh();
                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();
                abort(404,$exception);
            }
            return $cart;
        }

        public static function getOrCreateCart(string $questToken = null):Cart
        {
            $userId = Auth::id();
            if($userId) {
                return Cart::firstOrCreate(['user_id' => $userId]);
            }
            if($questToken) {
                return Cart::firstOrCreate(['guest_token' => $questToken]);
            }
            return Cart::createGuestCart();
        }
        public function checkProductAvailability(int $productId,int | null $variationID) {
            if($variationID) {
                return Variation::first(['id' => $variationID])->in_stock;
            }
            return Product::where(['id' => 1])->first()->in_stock;
        }

        public static function updateCartTotalPrice(Cart $cart):void
        {
            $cartItems = $cart->cartItems;
            $totalPrice = 0;
            $totalItems = 0;
            if(empty($cartItems)) {
                $cart->update([
                    'total_price' => $totalPrice,
                    'total_items' => $totalItems
                ]);
            }
            foreach ($cartItems as $cartItem) {
                $totalPrice+= $cartItem->price * $cartItem->quantity;
                $totalItems+= $cartItem->quantity;
            }

            $cart->update([
                'total_price' => $totalPrice,
                'total_items' => $totalItems
            ]);
        }
    }
