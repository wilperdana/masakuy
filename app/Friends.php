<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    //
    protected $table = 'm_friends';
    public $timestamps = false;

    public function dest_info() {
    	return $this->hasOne('App\User', 'userID', 'friendDest');
    }

    public function source_info() {
    	return $this->hasOne('App\User', 'userID', 'friendSource');
    }
}
