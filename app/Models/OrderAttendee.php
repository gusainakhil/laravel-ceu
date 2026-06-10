<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAttendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'order_id',
        'name',
        'email',
        'phone',
        'job_title',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }
}
