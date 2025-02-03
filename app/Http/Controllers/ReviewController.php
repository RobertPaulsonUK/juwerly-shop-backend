<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Resources\Admin\ReviewResource;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCartRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        try {
            DB::beginTransaction();
            $review = Review::create($data);
            DB::commit();
        } catch (\Exception) {
            DB::rollBack();
            abort(404);
        }

        return response()->json([
            'data' => new ReviewResource($review),
            'message' => 'Review was created successfully.'
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Review $review)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $review->update($data);
            $review->fresh();
            DB::commit();
        } catch (\Exception) {
            DB::rollBack();
            abort(404);
        }

        return response()->json([
            'data' => new ReviewResource($review),
            'message' => 'Review was updated successfully.'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();


        return response([
            'message' => "Review deleted successfully"
        ],200);
    }
}
