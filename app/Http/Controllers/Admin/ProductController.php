<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Resources\Admin\ProductCollectionResource;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Product;
use App\Service\Admin\ProductService;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->set_service(new ProductService());
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductCollectionResource::collection(Product::paginate(10)
                                                      ->withPath('/admin/products')
                                                      ->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $product = $this->service->store($data);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $product = $this->service->update($data,$product);

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();
            $product->delete();
            DB::commit();
        } catch (\Exception) {
            DB::rollBack();
            abort(404);
        }

        return response([
            'Product' => "Category deleted successfully"
        ],200);
    }
}
