<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
	public $timestamps = true;
	
	protected $fillable = ['name', 'permittype_id'];


    public function checklist(){
    	return $this->belongsToMany('App\MasterChecklist');
    }
    public function permittype(){
    	return $this->belongsTo('App\Permittype');
    }
}
