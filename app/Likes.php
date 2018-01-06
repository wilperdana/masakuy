<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    //
    protected $table = 'm_likes';
    public $timestamps = false;

    public function user_info() {
    	return $this->hasOne('App\User', 'userID', 'userID');
    }

    public function recipe_info() {
    	return $this->hasOne('App\User', 'recipeID', 'recipeID');	
    }
}
