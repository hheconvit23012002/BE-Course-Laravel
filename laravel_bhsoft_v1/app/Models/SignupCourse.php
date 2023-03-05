<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SignupCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'course',
    ];

    public function courses(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course');
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }
}
