<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SubscriptionPlanCourse extends Pivot
{
    protected $table = 'subscription_plan_courses';

    protected $fillable = [
        'plan_id',
        'course_id',
        'access_type',
    ];
}
