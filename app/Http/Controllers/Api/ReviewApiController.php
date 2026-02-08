<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewApiController extends Controller
{
    /**
     * Display reviews for a product.
     */
    public function index(Request $request)
    {
        $productId = $request->query('product_id');
        
        if ($productId) {
            $reviews = Review::where('product_id', $productId)
                ->with('user:id,name')
                ->latest()
                ->paginate(10);
        } else {
            $reviews = Review::with(['user:id,name', 'product:id,name'])
                ->latest()
                ->paginate(20);
        }

        return response()->json($reviews);
    }

    /**
     * Store a newly created review.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', $request->user()->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingReview) {
            return response()->json([
                'message' => 'You have already reviewed this product',
            ], 400);
        }

        $review = Review::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return response()->json([
            'message' => 'Review submitted successfully',
            'review' => $review->load('user:id,name'),
        ], 201);
    }

    /**
     * Display the specified review.
     */
    public function show($id)
    {
        $review = Review::with(['user:id,name', 'product'])->findOrFail($id);
        return response()->json($review);
    }

    /**
     * Update the specified review.
     */
    public function update(Request $request, $id)
    {
        $review = Review::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $request->validate([
            'rating' => 'sometimes|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $review->update($request->only(['rating', 'review']));

        return response()->json([
            'message' => 'Review updated successfully',
            'review' => $review->load('user:id,name'),
        ]);
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        
        // Users can only delete their own reviews, admins can delete any
        if ($user->isAdmin()) {
            $review = Review::findOrFail($id);
        } else {
            $review = Review::where('id', $id)
                ->where('user_id', $user->id)
                ->firstOrFail();
        }

        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully',
        ]);
    }
}
