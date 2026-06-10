<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SubscriptionPlanFeature extends Pivot
{
    protected $table = 'subscription_plan_features';

    protected $fillable = [
        'plan_id',
        'feature_id',
        'value',
    ];
}
