<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name'
    ];

    public function course(){
        return $this->belongsTo('\App\Models\Course');
    }
    public function user(){
        return $this->belongsTo('\App\User');
    }

}
