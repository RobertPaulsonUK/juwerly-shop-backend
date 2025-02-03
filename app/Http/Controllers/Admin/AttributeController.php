<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\StoreAttributeRequest;
use App\Http\Requests\Admin\UpdateAttributeRequest;
use App\Http\Resources\Admin\AttributeResource;
use App\Models\Attribute;
use App\Service\Admin\AttributeService;
use Illuminate\Support\Facades\DB;

class AttributeController extends BaseController
{

    public function __construct()
    {
        $this->set_service(new AttributeService());
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AttributeResource::collection(Attribute::paginate(10)
                                                      ->withPath('/admin/attributes')
                                                      ->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeRequest $request)
    {
        $data = $request->validated();
        $attribute = $this->service->store($data);

        return new AttributeResource($attribute);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attribute $attribute)
    {
        return new AttributeResource($attribute);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        $data = $request->validated();
        $attribute = $this->service->update($data,$attribute);

        return new AttributeResource($attribute);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Attribute $attribute)
    {
        try {
            DB::beginTransaction();
            $attribute->options()->delete();
            $attribute->delete();
            DB::commit();
        } catch (\Exception) {
            DB::rollBack();
            abort(404);
        }
        return response([
            'message' => "Attribute deleted successfully"
        ],200);

    }
}
