<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'group';
    public $timestamps = false;

    protected $fillable = ['name', 'creator'];

    public function messages() {
        return $this->belongsToMany('App\Models\Message');
    }

    public function participants() {
        return $this->belongsToMany('App\Models\User');
    }
}
