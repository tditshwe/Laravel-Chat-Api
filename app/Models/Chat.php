<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chat';
    public $timestamps = false;

    protected $fillable = ['last_message', 'sender', 'receiver'];

    protected $casts = [
        'is_group' => 'boolean',
        'last_message' => 'int'
    ];

    protected $attributes = [
        'is_group' => false,
    ];

    public function chatSender()
    {
        return $this->belongsTo('App\Models\User', 'sender');
    }

    public function chatReceiver()
    {
        return $this->belongsTo('App\Models\User', 'receiver');
    }
}
