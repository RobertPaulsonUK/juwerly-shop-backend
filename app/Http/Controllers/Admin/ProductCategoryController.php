<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductCategoryRequest;
use App\Http\Requests\Admin\UpdateProductCategoryRequest;
use App\Http\Resources\Admin\ProductCategoryResource;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductCategoryResource::collection(ProductCategory::paginate(10)
                                                                  ->withPath('/admin/product-category')
                                                                  ->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCategoryRequest $request)
    {
        $data = $request->validated();
        $productCategory = ProductCategory::create($data);
        return new ProductCategoryResource($productCategory);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        return new ProductCategoryResource($productCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $data = $request->validated();
        $productCategory->update($data);
        $productCategory->fresh();
        return new ProductCategoryResource($productCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        try {
            DB::beginTransaction();
            $productCategory->products()->update(['category_id' => null]);
            $productCategory->delete();
            DB::commit();
        } catch (\Exception) {
            DB::rollBack();
            abort(404);
        }


        return response([
            'message' => "Category deleted successfully"
        ],200);
    }
}
