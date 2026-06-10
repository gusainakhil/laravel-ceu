<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'input_type',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'status' => 'boolean',
    ];

    public function plans()
    {
        return $this->belongsToMany(SubscriptionPlan::class, 'subscription_plan_features', 'feature_id', 'plan_id')
            ->withPivot('value')
            ->withTimestamps();
    }
}
