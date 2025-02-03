<?php

namespace App\Http\Controllers;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\Cart\CreateCartRequest;
use App\Http\Requests\Cart\SimpleCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Http\Requests\Pages\ShopPageRequest;
use App\Http\Resources\Admin\ProductCollectionResource;
use App\Http\Resources\Cart\CartResource;
use App\Models\Product;
use App\Models\User;
use App\Service\CartService;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class ShopController extends Controller
{
    public function index(ShopPageRequest $request)
    {
        $data = $request->validated();
        $sortBy = $data['orderBy'] ?? 'name';
        $page = $data['page'] ?? 1;
        $perPage = $data['perPage'] ?? 12;
        $sortOrder = $data['order'] ?? 'asc';
        $filter = app()->make(ProductFilter::class,['queryParams' => array_filter($data)]);
        $products = Product::filter($filter)
                           ->orderBy($sortBy, $sortOrder)
                           ->paginate($perPage,['*'],'page',$page)
                           ->withPath('/products')
                           ->withQueryString();
        return ProductCollectionResource::collection($products);
    }
}
