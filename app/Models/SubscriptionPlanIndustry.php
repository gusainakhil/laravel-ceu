<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SubscriptionPlanIndustry extends Pivot
{
    protected $table = 'subscription_plan_industries';

    protected $fillable = [
        'plan_id',
        'industry_id',
    ];
}
