<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class venue extends Model
{
    public function specialOffers($booking){
    	$return = [];
    	$return['time'] = $booking->time_to_pay_for;
    	$return['price'] = $booking->base_hourly_rate;
    	$return['comment'] ='No Discount Applied';  //to add comment on to booking to explain any special offers applied
    	$return['discounted']=true;
    	return $return;
    }
}
