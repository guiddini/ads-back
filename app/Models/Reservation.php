<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Reservation extends Model
{
    use HasFactory, UUID;

    protected $fillable=[
        'user_id',
        'start_date',
        'end_date'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reservable(){
        return $this->morphTo();
    }
}
