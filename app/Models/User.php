<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $primaryKey = 'username';
    public $incrementing = false;
    protected $keyType = 'string';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','display_name', 'password', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token'
    ];

    protected $attributes = [
        'status' => 'Ready to chat',
    ];

    public function receivedMessages()
    {
        return $this->belongsToMany('App\Models\Message');
    }

    public function groupsCreated()
    {
        return $this->hasMany('App\Models\Group', 'creator');
    }

    public function groupsJoined()
    {
        return $this->belongsToMany('App\Models\Group');
    }
}
