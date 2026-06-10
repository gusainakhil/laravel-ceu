<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            if (!Schema::hasColumn('subscription_plans', 'stripe_price_id')) {
                $table->string('stripe_price_id')->nullable()->after('currency');
            }

            if (!Schema::hasColumn('subscription_plans', 'paypal_product_id')) {
                $table->string('paypal_product_id')->nullable()->after('stripe_price_id');
            }

            if (!Schema::hasColumn('subscription_plans', 'paypal_plan_id')) {
                $table->string('paypal_plan_id')->nullable()->after('paypal_product_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            if (Schema::hasColumn('subscription_plans', 'paypal_plan_id')) {
                $table->dropColumn('paypal_plan_id');
            }

            if (Schema::hasColumn('subscription_plans', 'paypal_product_id')) {
                $table->dropColumn('paypal_product_id');
            }

            if (Schema::hasColumn('subscription_plans', 'stripe_price_id')) {
                $table->dropColumn('stripe_price_id');
            }
        });
    }
};
