<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'industry_id',
        'speaker_id',
        'title',
        'slug',
        'short_description',
        'description',
        'certificate_text',
        'thumbnail',
        'event_date',
        'event_time',
        'duration_minutes',
        'single_sale_enabled',
        'subscription_enabled',
        'default_price',
        'currency',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
        'duration_minutes' => 'integer',
        'single_sale_enabled' => 'boolean',
        'subscription_enabled' => 'boolean',
        'default_price' => 'decimal:2',
    ];

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    // Alias for backward compatibility with frontend categories
    public function category()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }

    public function materials()
    {
        return $this->hasMany(CourseMaterial::class);
    }

    public function pricings()
    {
        return $this->hasMany(CoursePricing::class);
    }

    public function coursePricings()
    {
        return $this->hasMany(CoursePricing::class);
    }

    public function subscriptionPlans()
    {
        return $this->belongsToMany(SubscriptionPlan::class, 'subscription_plan_courses', 'course_id', 'plan_id');
    }

    public function getDurationMinsAttribute()
    {
        return $this->duration_minutes;
    }

    public function getScheduledAtAttribute()
    {
        if ($this->event_date) {
            $dt = \Carbon\Carbon::parse($this->event_date);
            if ($this->event_time) {
                $timeParts = explode(':', $this->event_time);
                if (count($timeParts) >= 2) {
                    $dt->setTime((int)$timeParts[0], (int)$timeParts[1], (int)($timeParts[2] ?? 0));
                }
            }
            return $dt;
        }
        return null;
    }
    public function getPriceAttribute()
    {
        return $this->default_price;
    }
}
