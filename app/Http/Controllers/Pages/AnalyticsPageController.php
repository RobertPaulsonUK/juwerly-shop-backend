<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\GeneralPageRequest;
use App\Http\Resources\GeneralPageResource;
use App\Models\AnalyticsPage;

class AnalyticsPageController extends Controller
{
    protected AnalyticsPage $page;

    public function __construct()
    {
        $this->page = AnalyticsPage::firstOrFail();
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
