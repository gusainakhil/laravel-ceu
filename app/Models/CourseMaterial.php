<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'type',
        'title',
        'file_path',
        'external_url',
        'is_downloadable',
        'status',
    ];

    protected $casts = [
        'is_downloadable' => 'boolean',
        'status' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
