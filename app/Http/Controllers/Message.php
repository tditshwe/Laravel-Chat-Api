<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';
    public $timestamps = false;
    //const CREATED_AT = 'date_sent';
}
