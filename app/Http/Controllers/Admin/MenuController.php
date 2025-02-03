<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMenuRequest;
use App\Http\Requests\Admin\UpdateMenuRequest;
use App\Http\Resources\Admin\MenuResource;
use App\Http\Resources\Admin\MenuResourceCollection;
use App\Models\Menu;
use App\Service\Admin\MenuService;
use Illuminate\Support\Facades\DB;

class MenuController extends BaseController
{
    public function __construct()
    {
        $this->service = new MenuService();
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MenuResourceCollection::collection(Menu::paginate(10)
                                                      ->withPath('/admin/menu')
                                                      ->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        $data = $request->validated();
        $menu = $this->service->store($data);

        return new MenuResource($menu);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return new MenuResource($menu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $data = $request->validated();
        $menu = $this->service->update($data,$menu);

        return new MenuResource($menu);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        try {
            DB::beginTransaction();
            $menu->menuItems()->delete();
            $menu->delete();
            DB::commit();
        } catch (\Exception) {
            DB::rollBack();
            abort(404);
        }
        return response([
            'message' => "Menu deleted successfully"
        ],200);
    }
}
