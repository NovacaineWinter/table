<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname','lname', 'email', 'password','role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    

    public function role(){
        return $this->belongsTo('App\role','role_id');
    }    

    public function bookings(){
        return $this->belongsToMany('App\booking', 'users_bookings', 'user_id', 'booking_id');
    }    

    public function updateProfilePic($file){
            //only deals with saving a large form of the user's profile pic - Will sort out thumbnails at some point
        $this->img_raw = $request->file('input_img')->store('public');
        $this->save();
    }

    public function profileThumb(){
        return url($this->img_raw);
    }

    public function profileMedium(){
        return url($this->img_raw);
    }

    public function hasErrors(){
        return false;
    }
}
