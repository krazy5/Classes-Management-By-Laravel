<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
   use HasFactory;

    protected $fillable = [
        'batch_id',
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'send_notification',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
