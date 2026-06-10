<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'mode',
        'is_default',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function settings()
    {
        return $this->hasMany(PaymentGatewaySetting::class, 'gateway_id');
    }

    public function getSetting($key)
    {
        $setting = $this->settings()->where('setting_key', $key)->first();
        if ($setting) {
            return $setting->getValue();
        }
        return null;
    }
}
