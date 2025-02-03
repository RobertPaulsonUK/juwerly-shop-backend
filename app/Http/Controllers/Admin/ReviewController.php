<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ReviewResource::collection(Review::paginate(10)
                                          ->withPath('/admin/reviews')
                                          ->withQueryString()
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return new ReviewResource($review);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        try {
            DB::beginTransaction();
            $review->delete();
            DB::commit();
        } catch (\Exception) {
            DB::rollBack();
            abort(404);
        }


        return response([
            'message' => "Review deleted successfully"
        ],200);
    }
}
