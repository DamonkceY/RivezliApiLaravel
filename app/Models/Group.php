<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
    ];

    public function department(){
        return $this->belongsTo('App\Models\Department');
    }

    public function students(){
        return $this->hasMany('App\User');
    }

    public function courses(){
        return $this->hasMany('\App\Models\Course');
    }

    public function messages(){
        return $this->hasMany('App\Models\Message');
    }
}
