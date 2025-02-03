<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\GeneralPageRequest;
use App\Http\Resources\GeneralPageResource;
use App\Models\ContactsPage;

class ContactsPageController extends Controller
{
    protected ContactsPage $page;

    public function __construct()
    {
        $this->page = ContactsPage::firstOrFail();
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
