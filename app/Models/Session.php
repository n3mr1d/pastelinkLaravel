<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';

    protected $fillable = [
        'id', 'user_id', 'ip_address', 'user_agent', 'username', 'payload', 'last_activity'
    ];

    public $timestamps = false;

    /**
     * Get the current session ID.
     *
     * @return string|null
     */
    public static function getId()
    {
        return session()->getId();
    }
}
