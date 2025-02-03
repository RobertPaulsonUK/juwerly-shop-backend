<?php

    namespace App\Service;

    use App\Models\Order;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\DB;

    class OrderService
    {
       public function storeOrder(array $data):Order | null
       {
           try {
               DB::beginTransaction();
               $cart = CartService::getOrCreateCart($data['quest_token'] ?? null);
               $cartItems = $cart->cartItems;
               $gifts = $cart->gifts;
               if(count($cartItems) === 0) {
                   return null;
               }
               if(isset($data['quest_token'])) {
                   unset($data['quest_token']);
               }
               $data['total_price'] = $cart->discount_price ?? $cart->total_price;
               $data['items_count'] = $cart->total_items + count($gifts);
               $order = Order::create($data);
                $itemsData = $this->prepareOrderItemsData($cartItems);
                $order->order_items()->create($itemsData);
                if(!empty($gifts)) {
                    foreach ($gifts as $gift)
                    {
                        $order->order_items()->create($gift->prepareDataForOrder);
                    }
                }
                $cart->delete();
               DB::commit();
           } catch (\Exception $exception) {
                DB::rollBack();
                abort(404);
           }
            return $order;

       }


       public function prepareOrderItemsData( Collection $cartItems):array
       {
           $data = [];
           foreach ($cartItems as $cartItem)
           {
               $data = [
                   'name' => $cartItem->name,
                   'url' => $cartItem->url,
                   'image_url' => $cartItem->image_url,
                   'quantity' => $cartItem->quantity,
                   'price' => $cartItem->price,
               ];
           }
           return $data;
       }


    }
