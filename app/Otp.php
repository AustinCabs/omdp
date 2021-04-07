<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{

	public $timestamps = true;
	
    public function billings(){
    	return $this->hasMany('App\Billing');
    }

    public function masterlist(){
    	return $this->belongsTo('App\Masterlist');
    }
}
