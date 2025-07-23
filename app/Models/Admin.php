<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';

    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'full_name', 'contact', 'email', 'user_name', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sentMessages(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(\App\Models\Message::class, 'sender');
    }

    public function receivedMessages(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(\App\Models\Message::class, 'recipient');
    }
}
