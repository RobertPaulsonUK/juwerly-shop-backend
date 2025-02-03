<?php

namespace App\Http\Controllers;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\Cart\CreateCartRequest;
use App\Http\Requests\Cart\SimpleCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Http\Requests\Pages\CategoryPageRequest;
use App\Http\Requests\Pages\ShopPageRequest;
use App\Http\Resources\Admin\ProductCategoryResource;
use App\Http\Resources\Admin\ProductCollectionResource;
use App\Http\Resources\Cart\CartResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use App\Service\CartService;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class CategoryController extends Controller
{
    public function index(ProductCategory $product_category)
    {
        return new ProductCategoryResource($product_category);
    }

    public function products(CategoryPageRequest $request,ProductCategory $product_category)
    {
        $data = $request->validated();
        $sortBy = $data['orderBy'] ?? 'name';
        $sortOrder = $data['order'] ?? 'asc';
        $page = $data['page'] ?? 1;
        $perPage = $data['perPage'] ?? 12;
        $filter = app()->make(ProductFilter::class,['queryParams' => array_filter($data)]);
        $products = $product_category->products()
                                     ->filter($filter)
                                     ->orderBy($sortBy, $sortOrder)
                                     ->paginate($perPage,['*'],'page',$page)
                                     ->withPath("/product-category/{$product_category->slug}")
                                     ->withQueryString();

        return ProductCollectionResource::collection($products);
    }
}
