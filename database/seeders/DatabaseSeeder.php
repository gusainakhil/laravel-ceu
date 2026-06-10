<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed default admin (super_admin)
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@ceutrainers.com'],
            [
                'name' => 'Super Admin Specialist',
                'password' => Hash::make('`password123`'),
                'role' => 'super_admin',
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=150&h=150&q=80',
                'status' => 'active',
            ]
        );

        // Seed default customer (customer)
        $customer = \App\Models\User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Alex Mercer',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80',
                'status' => 'active',
            ]
        );

        // Seed customer default billing address
        \App\Models\UserAddress::updateOrCreate(
            [
                'user_id' => $customer->id,
                'type' => 'billing',
            ],
            [
                'name' => 'Alex Mercer',
                'phone' => '+1 (555) 019-2834',
                'company_name' => 'Mercer & Co.',
                'address_line_1' => '123 CEU Training Blvd',
                'address_line_2' => 'Suite 400',
                'city' => 'Austin',
                'state' => 'TX',
                'country' => 'USA',
                'postal_code' => '78701',
                'is_default' => 1,
            ]
        );

        $this->call([
            SpeakerSeeder::class,
            CourseSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
