<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speaker extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'designation',
        'bio',
        'image',
        'resume',
        'is_verified',
        'status',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
