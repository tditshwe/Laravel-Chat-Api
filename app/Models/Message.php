<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';
    public $timestamps = false;

    protected $fillable = ['text', 'sender', 'date_sent'];

    protected $casts = ['date_sent' => 'datetime'];
}
