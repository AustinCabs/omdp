<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{	
	public $timestamps = true;
    protected $fillable = ['name', 'date'];
}
