<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    //
    protected $table = 'm_recipes';
    protected $primaryKey = 'recipeID';
    //public $timestamps = false;

    public function user_info() {
    	return $this->hasOne('App\User', 'userID', 'userID');
    }
    
    public function user_comments() {
    	return $this->hasMany('App\Comments', 'recipeID', 'recipeID');
    }
}
