<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Masterlist extends Model
{   
    public $timestamps = true;
    
    protected $fillable = [
                'img',
                'business_name',
                'owner_name',
                'permit_no',
                'prk',
                'brgy',
                'municipality',
                'province',
                'island',
                'date_filed',
                'tin_no',
                'contact_no',
                'type',
                'permittype_id',
                'area_volume',
                'longhitude',
                'latitude',
                'query_code',
                'application_type',
                'expiry_date'
            ];
    public function otps(){
    	return $this->hasMany('App\Otp');
    }

    public function billings(){
    	return $this->hasMany('App\Billing');
    }

    public function permit_type(){
    	return $this->belongsTo('App\Permittype');
    }

    public function checklist(){
    	return $this->hasMany('App\MasterChecklist');
    }

    public function reports(){
        return $this->hasMany('App\Report');
    }
}
