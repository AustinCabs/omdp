<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    
	public $timestamps = true;
	protected $fillable = ['contact', 'msg','status'];
}
