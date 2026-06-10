<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'api_key',
        'api_secret_hash',
        'permissions',
        'last_used_at',
        'status',
    ];

    protected $casts = [
        'permissions' => 'array',
        'last_used_at' => 'datetime',
        'status' => 'boolean',
    ];
}
