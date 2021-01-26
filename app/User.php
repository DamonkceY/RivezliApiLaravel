<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }
    public function files()
    {
        return $this->hasMany('\App\Models\File');
    }
    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }

    public function groups()
    {
        return $this->hasMany('App\Models\ProfGroupRelation');
    }
}
