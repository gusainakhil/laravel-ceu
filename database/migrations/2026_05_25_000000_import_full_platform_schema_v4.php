<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $sqlPath = base_path('laravel_full_platform_schema_v4.sql');
        if (!file_exists($sqlPath)) {
            throw new \Exception("laravel_full_platform_schema_v4.sql not found at " . $sqlPath);
        }

        $sql = file_get_contents($sqlPath);
        
        // Execute the multi-query raw SQL
        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Dropping tables
        $tables = [
            'system_settings', 'mail_settings', 'payment_gateway_settings', 'payment_gateways',
            'webhook_events', 'payment_transactions', 'order_attendees', 'order_items', 'orders',
            'cart_items', 'carts', 'user_course_accesses', 'user_subscriptions',
            'subscription_plan_courses', 'subscription_plan_industries', 'subscription_plan_features',
            'subscription_features', 'subscription_plans', 'course_pricing',
            'registration_option_template_items', 'registration_option_templates',
            'course_materials', 'courses', 'coupons', 'user_addresses', 'users', 'speakers',
            'industries', 'faqs', 'faq_categories', 'contact_enquiries', 'api_clients'
        ];

        if (config('database.default') !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        }

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }

        if (config('database.default') !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }
    }
};
