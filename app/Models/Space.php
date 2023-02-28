<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'desc',
        'image',
        'cat',
        'price',
        'height',
        'width',
        'location'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reservations(){
        return $this->morphMany(Reservation::class, 'reservable');
    }
}
