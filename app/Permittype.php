<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Checklist;

class Permittype extends Model
{
	public $timestamps = true;
	protected $fillable = ['name', 'validity_type', 'validity_unit', 'doc_name', 'type'];
    public function masterlists(){
    	return $this->hasMany('App\Masterist');
    }

    public static function checklist($id){
    	return Checklist::where('permittype_id',  $id)->get();
    }

    public static function getDetails($id){
    	return Permittype::where('id', $id)->first();
    }

    public function checks(){
        return $this->hasMany('App\Checklist');
    }

    public function billingTypes(){
        return $this->hasMany('App\BillingType');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($e) { 
             $e->billingTypes()->delete();
             $e->checks()->delete();
        });
    }
}
