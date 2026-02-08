<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->default('cash_on_delivery')->after('total_amount');
            $table->string('payment_status')->default('pending')->after('payment_method');
            $table->string('stripe_payment_intent_id')->nullable()->after('payment_status');
            $table->string('stripe_checkout_session_id')->nullable()->after('stripe_payment_intent_id');
            $table->decimal('payment_amount', 10, 2)->nullable()->after('stripe_checkout_session_id');
            $table->timestamp('paid_at')->nullable()->after('payment_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'payment_status',
                'stripe_payment_intent_id',
                'stripe_checkout_session_id',
                'payment_amount',
                'paid_at'
            ]);
        });
    }
};
