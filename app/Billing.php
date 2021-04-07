<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
	public $timestamps = true;
	protected $fillable = [
			'or_no',
			'amount',
			'date_paid',
			'fee',
			'name',
			'status',
			'masterlist_id',
			'type'
		];
    public function masterlist(){
    	return $this->belongsTo('App\Masterlist');
    }

    public function otp(){
    	return $this->belongsTo('App\Otp');
    }
}
