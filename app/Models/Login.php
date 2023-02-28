<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'ip',
        'country',
        'country_code',
        'region',
        'region_code',
        'city',
        'zip',
        'lat',
        'long',
        'login_date_time'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
