<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function questions(){
        return $this->hasMany('App\Models\Question');
    }

    public function user(){
        return $this->hasOne('App\Models\UserData');
    }
}
