<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingType extends Model
{
    public $timestamps = true;
    protected $fillable = ['name', 'fee', 'permittype_id'];

    public function permitType(){
    	return $this->belongsTo('App\Permittype');
    }
}
