<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Personal\WishlistResource;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlist = Auth::user()->wishlistProducts;
        return WishlistResource::collection($wishlist);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add(int $id)
    {
        $product = Product::where('id','=',$id)->first();
        if(!$product) {
            return response()->json([
                'message' => 'The provided product id is incorrect'
            ],404);
        }
        $item =  Wishlist::add($id);
        if(!$item) {
            return response()->json([
                'message' => 'Something went wrong...Please try later'
            ],404);
        }
        $wishlist = Auth::user()->wishlistProducts;

        return response()->json([
            'data' => WishlistResource::collection($wishlist),
            'message' => 'Product is added to wishlist successfully!'
        ]);

    }


    /**
     * Remove the specified resource from storage.
     */
    public function remove(int $id)
    {
        $product = Product::where('id','=',$id)->first();
        if(!$product) {
            return response()->json([
                'message' => 'The provided product id is incorrect'
            ],404);
        }

        $result = Wishlist::remove($id);

        if(!$result) {
            return response()->json([
                'message' => 'Something went wrong...Please try later'
            ],404);
        }

        $wishlist = Auth::user()->wishlistProducts;

        return response()->json([
            'data' => WishlistResource::collection($wishlist),
            'message' => 'Product is removed from wishlist successfully!'
        ]);
    }
}
