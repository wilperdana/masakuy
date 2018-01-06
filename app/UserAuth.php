<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAuth extends Model
{
    protected $table = 'm_users_auth';
    protected $primary_key = 'userID';
    public $timestamps = false;
}
