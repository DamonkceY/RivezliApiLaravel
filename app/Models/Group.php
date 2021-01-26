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

    public function users(){
        return $this->hasMany('App\User');
    }
    public function students(){
        return $this->users()->where('role',0);
    }

    public function courses(){
        return $this->hasMany('\App\Models\Course');
    }

    public function messages(){
        return $this->hasMany('App\Models\Message');
    }

    public function profs()
    {
       return $this->hasMany('App\Models\ProfGroupRelation');
    }


}
