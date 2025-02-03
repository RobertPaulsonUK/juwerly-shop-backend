<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\GeneralPageRequest;
use App\Http\Resources\GeneralPageResource;
use App\Models\AboutPage;

class AboutPageController extends Controller
{
    protected AboutPage $page;

    public function __construct()
    {
        $this->page = AboutPage::firstOrFail();
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
