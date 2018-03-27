<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class table_type extends Model
{
    protected $table = 'table_types';

    public function tables(){
    	return $this->hasMany('App\table','type_id');
    }
}
