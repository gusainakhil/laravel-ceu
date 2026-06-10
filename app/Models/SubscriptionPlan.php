<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'currency',
        'stripe_price_id',
        'paypal_product_id',
        'paypal_plan_id',
        'duration_days',
        'free_extra_days',
        'max_course_access',
        'access_all_live_webinars',
        'access_all_recordings',
        'access_all_transcripts',
        'priority_support',
        'is_popular',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'free_extra_days' => 'integer',
        'max_course_access' => 'integer',
        'access_all_live_webinars' => 'boolean',
        'access_all_recordings' => 'boolean',
        'access_all_transcripts' => 'boolean',
        'priority_support' => 'boolean',
        'is_popular' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function features()
    {
        return $this->belongsToMany(SubscriptionFeature::class, 'subscription_plan_features', 'plan_id', 'feature_id')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'subscription_plan_courses', 'plan_id', 'course_id')
            ->withPivot('access_type');
    }

    public function industries()
    {
        return $this->belongsToMany(Industry::class, 'subscription_plan_industries', 'plan_id', 'industry_id');
    }
}
