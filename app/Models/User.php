<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Traits\UUID;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use UUID, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'picture',
        'email',
        'phone',
        'dob',
        'address',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function logins(){
        return $this->hasMany(Login::class);
    }

    public function spaces(){
        return $this->hasMany(Space::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }
}
