<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationOptionTemplateItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'category',
        'label',
        'attendees',
        'price',
        'compare_at_price',
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

    public function template()
    {
        return $this->belongsTo(RegistrationOptionTemplate::class, 'template_id');
    }
}
