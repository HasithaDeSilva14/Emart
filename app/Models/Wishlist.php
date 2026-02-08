<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'product_id'];

    /**
     * Get the user that owns the wishlist item
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product in the wishlist
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Toggle wishlist item for a user and product
     */
    public static function toggle(int $userId, int $productId): bool
    {
        $wishlist = self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return false; // Removed from wishlist
        } else {
            self::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            return true; // Added to wishlist
        }
    }

    /**
     * Check if product is in user's wishlist
     */
    public static function isInWishlist(int $userId, int $productId): bool
    {
        return self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }
}
