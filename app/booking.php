<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
    public function users(){
    	return $this->belongsToMany('App\User', 'users_bookings', 'booking_id', 'user_id');
    }
}
