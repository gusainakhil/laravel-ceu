<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class CampaignDataSeeder extends Seeder
{
    public function run(): void
    {
        $campaigns = [
            ['utm_source' => 'Google', 'utm_medium' => 'CPC', 'utm_campaign' => 'spring_sale_2026'],
            ['utm_source' => 'Facebook', 'utm_medium' => 'Social', 'utm_campaign' => 'discount_2026'],
            ['utm_source' => 'Newsletter', 'utm_medium' => 'Email', 'utm_campaign' => 'promo_may'],
            ['utm_source' => 'LinkedIn', 'utm_medium' => 'Organic', 'utm_campaign' => 'speakers_series'],
        ];

        $orders = Order::all();
        
        foreach ($orders as $index => $order) {
            $notesData = json_decode($order->notes, true) ?: [];
            
            // Distribute campaigns realistically among the 15 orders:
            // Google CPC: 4 orders
            // Facebook Social: 3 orders
            // Newsletter Email: 2 orders
            // LinkedIn Organic: 1 order
            // Direct / Unknown / Not Set: 5 orders
            if ($index < 4) {
                $utm = $campaigns[0]; // Google
            } elseif ($index < 7) {
                $utm = $campaigns[1]; // Facebook
            } elseif ($index < 9) {
                $utm = $campaigns[2]; // Newsletter
            } elseif ($index < 10) {
                $utm = $campaigns[3]; // LinkedIn
            } else {
                $utm = [
                    'utm_source' => null,
                    'utm_medium' => null,
                    'utm_campaign' => null
                ];
            }
            
            $notesData['utm_data'] = $utm;
            
            $order->notes = json_encode($notesData);
            $order->save();
        }
    }
}
