<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For SQLite, we need to recreate the table with new enum values
        // First, update any 'completed' status to 'delivered'
        DB::table('orders')
            ->where('status', 'completed')
            ->update(['status' => 'delivered']);
        
        // SQLite doesn't support ALTER COLUMN for ENUM, so we use a workaround
        // The status field will accept the new values
        DB::statement("UPDATE orders SET status = 'delivered' WHERE status = 'completed'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert 'delivered' back to 'completed'
        DB::table('orders')
            ->where('status', 'delivered')
            ->update(['status' => 'completed']);
    }
};
