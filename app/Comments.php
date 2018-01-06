<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //
    protected $table = 'm_comments';
    protected $primary_key = 'commentID';

    public function user_info() {
    	return $this->hasOne('App\User', 'userID', 'userID');
    }
}
