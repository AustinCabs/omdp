<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public $timestamps = true;
    
    public static function type($id){
    	return Type::where('id', $id)->first();
    }
}
