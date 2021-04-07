<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Checklist;

class MasterChecklist extends Model
{

	public $timestamps = true;
	protected $fillable = [
			'name',
			'masterlist_id',
            'status'
		];
    public function masterlist(){
    	return $this->belongsTo('App\Masterlist');
    }

    public static function getChecklistDetails($id){
    	return Checklist::where('id', $id)->first();
    }
}
