<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'm_users';
    protected $primaryKey = 'userID';
    public $timestamps = false;

    public function user_auth() {
    	return $this->hasOne('App\UserAuth', 'userID', 'userID');
    }
}
