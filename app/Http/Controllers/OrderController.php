<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\DeliveryMethod;
use App\Models\PaymentMethod;
use App\Service\OrderService;


class OrderController extends BaseController
{


    public function __construct()
    {
        $this->service = new OrderService();
    }


    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $order = $this->service->storeOrder($data);
        event(new OrderCreated($order));

    }

    public function index()
    {
        $availableDeliveryMethods = DeliveryMethod::getActiveMethods()->pluck('title');
        $availablePaymentMethods = PaymentMethod::getActiveMethods()->pluck('title');


    }

}
