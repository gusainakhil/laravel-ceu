<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePricing extends Model
{
    use HasFactory;

    protected $table = 'course_pricing';

    protected $fillable = [
        'course_id',
        'template_item_id',
        'category',
        'label',
        'attendees',
        'price',
        'compare_at_price',
        'currency',
        'description',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'sort_order' => 'integer',
        'status' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function templateItem()
    {
        return $this->belongsTo(RegistrationOptionTemplateItem::class, 'template_item_id');
    }
}
