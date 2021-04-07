<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
   	public $timestamps = true;
	protected $fillable = [
		'materials',
		'p_quantity',
		'p_value',
		's_quantity',
		's_value',
		'm_inventory_q',
		'm_inventory_v',
		'fee_payable',
		'tax_payable',
		'buyer_address',
		'report_id'
		];

	public function report(){
    	return $this->belongsTo('App\Report');
    }
}
