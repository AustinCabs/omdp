<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    
    public $timestamps = true;
	protected $fillable = [
		'o_male',
		'o_female',
		's_male',
		's_female',
		'report_id'
		];

	public function report(){
    	return $this->belongsTo('App\Report');
    }
}
