<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;
    use HasFactory;
    use Notifiable;

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'signup_courses', 'user', 'course');
    }

    protected $fillable = [
        'name',
        'email',
        'birthdate',
        'phone_number',
        'logo',
        'password',
    ];
}
