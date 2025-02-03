<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\GeneralPageRequest;
use App\Http\Resources\GeneralPageResource;
use App\Models\PaymentTutorialPage;

class PaymentTutorialPageController extends Controller
{
    protected PaymentTutorialPage $page;

    public function __construct()
    {
        $this->page = PaymentTutorialPage::firstOrFail();
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
