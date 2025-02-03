<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\HomePageRequest;
use App\Http\Resources\HomePageResource;
use App\Models\HomePage;

class HomePageController extends Controller
{
    protected HomePage $page;

    public function __construct()
    {
        $this->page = HomePage::firstOrFail();
    }

    public function show()
    {
        return new HomePageResource($this->page);
    }

    public function update(HomePageRequest $request)
    {
        $data = $request->validated();
        $this->page->update($data);

        return new HomePageResource($this->page);
    }

}
