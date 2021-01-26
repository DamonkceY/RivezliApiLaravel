<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfGroupRelation extends Model
{

    protected $guarded = [];

    public function group(){
        return $this->belongsTo('App\Models\Group');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
