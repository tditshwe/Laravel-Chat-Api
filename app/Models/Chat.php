<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chat';
    public $timestamps = false;

    protected $casts = [
        'is_group' => 'boolean',
        'last_message' => 'int'
    ];

    protected $attributes = [
        'is_group' => false,
    ];
}
