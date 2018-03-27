<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class table extends Model
{
    protected $table = 'tables';

    public function type(){
    	return $this->belongsTo('App\table_type','type_id');
    }

    public function currentHourlyRate($membership_level=0){
        return 600;
    }

    public function currentBooking(){
    	return $this->belongsTo('App\booking','current_booking_id');
    }

    public function bookings(){
    	return $this->hasMany('App\booking','table_id');
    }

    public function startTable(){
        $this->is_occupied = true;
        $this->currentBooking->time_start = time();
        $this->currentBooking->base_hourly_rate = 600;
        $this->currentBooking->save();
        $this->save();
    }
    public function stopTable(){
        $this->is_occupied = false;
        $this->currentBooking->time_finish = time();
        $this->currentBooking->time_to_pay_for = $this->currentBooking->time_to_pay_for + ($this->currentBooking->time_finish - $this->currentBooking->time_start);

        $venue = new \App\venue;
        $data = $venue->specialOffers($this->currentBooking);

            //based on venue's own decision on pricing invervals
        $interval = \App\config::where('name','=','chargeableInterval')->first()->integer;

        $timeUnitsUsed = floor($data['time']/$interval);
        $costPerTimeUnit = ($data['price']/(3600/$interval))/100;

        $this->currentBooking->cost = round($timeUnitsUsed * $costPerTimeUnit,2);

        $this->currentBooking->comments = $this->currentBooking->comments.' '.$data['comment'];

        $this->currentBooking->save();

        $this->transferToTill();
        $this->turnOffLights();
        $this->updateTimeUsed($this->currentBooking->time_to_pay_for);

        $oldBooking = $this->currentBooking;

        $newBooking = new \App\booking;
        $newBooking->table_id = $this->id;
        $newBooking->save();

        $this->current_booking_id = $newBooking->id;

        

        $this->save();

        $return['success'] = true;
        $return['cost'] = $oldBooking->cost;
        $return['discount'] = $data['discounted'];
        $return['comments'] = $oldBooking->comments;

        return $return; 

        /* Send request to hardware to stop light */

    }

    public function cancelTable(){
        $this->is_occupied = false;
        $this->currentBooking->time_start = null;
        $this->currentBooking->time_finish = null;
        $this->currentBooking->time_to_pay_for = 0;
        $this->currentBooking->cost = null;
        $this->currentBooking->base_hourly_rate = null;
        $this->currentBooking->been_transfered_to_till = false;
        $this->currentBooking->been_paid = false;
        $this->currentBooking->comments = '';
        $this->currentBooking->save();
        $bookings = \App\users_bookings::where('booking_id','=',$this->current_booking_id)->delete();
        $this->save();
        $this->turnOffLights();
        $result['success'] = true;
        return $result;
    }


    public function updateTimeUsed($time){
        $this->time_total = $this->time_total + $time;
        $this->time_since_recushion = $this->time_since_recushion + $time;
        $this->time_since_recloth = $this->time_since_recloth + $time;
        $this->time_since_clean = $this->time_since_clean + $time;
        $this->save();
    }






    public function transferToTill(){
        //just a placeholder at the min - does nothing
        $this->currentBooking->been_transfered_to_till = true;
        $this->currentBooking->save();
        return true;
    }

    public function turnOffLights(){
        return true;
    }
}
