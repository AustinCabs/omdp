<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{	
	protected $fillable = [
		'url',
		'action',
		'added_by',
		'masterlist_id',
		'author'
		];
	public $timestamps = true;
	
    public function user(){
    	return $this->belongsTo('App\User');
    }
}
