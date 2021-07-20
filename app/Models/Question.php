<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function answers(){
        return $this->hasMany('App\Models\Answer')->orderBy('option_value');
    }

    public function test(){
        return $this->belongsTo('App\Models\Test');
    }

    public function correctAnswer(){
        return $this->hasOne('App\Models\Answer')->where('is_correct', true);
    }

    public function selectedAnswer(){
        return $this->hasOne('App\Models\Answer')->where('selected_by_user', true);
    }
}
