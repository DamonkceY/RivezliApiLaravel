<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name'
    ];

    public function files(){
        return $this->hasMany('\App\Models\File');
    }

    public function group(){
        return $this->belongsTo('\App\Models\Group');
    }

    public function user(){
        return $this->belongsTo('\App\User');
    }
}
