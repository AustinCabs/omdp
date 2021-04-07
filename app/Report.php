<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public $timestamps = true;
	protected $fillable = [
		'date',
        'days_of_operation',
        'prepared_by',
        'masterlist_id',
        'permittype_id',
        'updated_at',
        'created_at'
		];

	public function masterlist(){
    	return $this->belongsTo('App\Masterlist');
    }

    public function productions(){
    	return $this->hasMany('App\Production');
    }

    public function employment(){
        return $this->hasOne('App\Employment');
    }
}
