<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WishlistController extends Controller
{
    /**
     * Toggle product in wishlist
     */
    public function toggle(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $added = Wishlist::toggle(
            auth()->id(),
            $request->product_id
        );

        return response()->json([
            'success' => true,
            'added' => $added,
            'message' => $added ? 'Added to wishlist' : 'Removed from wishlist',
            'count' => Wishlist::where('user_id', auth()->id())->count(),
        ]);
    }

    /**
     * Get wishlist count for current user
     */
    public function count(): JsonResponse
    {
        $count = Wishlist::where('user_id', auth()->id())->count();
        
        return response()->json(['count' => $count]);
    }
}
