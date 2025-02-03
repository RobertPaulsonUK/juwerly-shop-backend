<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CreateCartRequest;
use App\Http\Requests\Cart\SimpleCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\User;
use App\Service\CartService;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class CartController extends BaseController
{


    public function __construct()
    {
        $this->service = new CartService();
    }

    public function show( SimpleCartRequest $request)
    {
        $data = $request->validated();
        $cart = $this->service->getOrCreateCart($data['quest_token'] ?? null);
        $cart->checkCartItemsAvailability();

        return new CartResource($cart);
    }

    public function add(CreateCartRequest $request)
    {
        $data = $request->validated();
        $cart = $this->service->addItem($data);
        $cart->checkCartItemsAvailability();

        return new CartResource($cart);
    }
    public function update(UpdateCartRequest $request)
    {
        $data = $request->validated();
        $cart = $this->service->updateItem($data);
        $cart->checkCartItemsAvailability();

        return new CartResource($cart);
    }

    public function clear(SimpleCartRequest $request)
    {
        $data = $request->validated();
        $cart = $this->service->getOrCreateCart($data['quest_token'] ?? null);

        $cart->cartItems()->delete();

        return new CartResource($cart);
    }

}
