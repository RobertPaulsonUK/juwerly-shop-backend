<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\GeneralPageRequest;
use App\Http\Resources\GeneralPageResource;
use App\Models\PaymentAndDeliveryPage;

class PaymentDeliveryPageController extends Controller
{
    protected PaymentAndDeliveryPage $page;

    public function __construct()
    {
        $this->page = PaymentAndDeliveryPage::firstOrFail();
    }

    public function show()
    {
        return new GeneralPageResource($this->page);
    }

    public function update(GeneralPageRequest $request)
    {
        $data = $request->validated();
        $this->page->update($data);

        return new GeneralPageResource($this->page);
    }

}
