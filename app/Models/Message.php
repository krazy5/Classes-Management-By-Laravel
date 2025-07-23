<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Get the parent sender model (Admin, StudentRecord, etc.).
     */
    public function sender(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the parent recipient model (Admin, StudentRecord, etc.).
     */
    public function recipient(): MorphTo
    {
        return $this->morphTo();
    }
}