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
        // For MySQL/PostgreSQL/SQL Server, we can verify checking schema builder
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('status')->default('pending')->change();
            });
            return;
        }

        // SQLite doesn't support modifying CHECK constraints directly
        // We need to recreate the table without the enum constraint
        
        // Step 1: Create a new table without the CHECK constraint
        Schema::create('orders_new', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('pending'); // Changed from enum to string
            $table->text('shipping_address');
            $table->string('phone')->nullable();
            $table->timestamps();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('stripe_checkout_session_id')->nullable();
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('sandbox_transaction_id')->nullable();
            $table->string('tracking_number')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
        });
        
        // Step 2: Copy all data from old table to new table
        DB::statement('INSERT INTO orders_new SELECT * FROM orders');
        
        // Step 3: Drop the old table
        Schema::dropIfExists('orders');
        
        // Step 4: Rename the new table to orders
        Schema::rename('orders_new', 'orders');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate with enum constraint
        Schema::create('orders_old', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->text('shipping_address');
            $table->string('phone')->nullable();
            $table->timestamps();
        });
        
        DB::statement('INSERT INTO orders_old (id, user_id, total_amount, status, shipping_address, phone, created_at, updated_at) 
                       SELECT id, user_id, total_amount, status, shipping_address, phone, created_at, updated_at FROM orders');
        
        Schema::dropIfExists('orders');
        Schema::rename('orders_old', 'orders');
    }
};
