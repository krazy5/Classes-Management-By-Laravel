<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
     use HasFactory;

    protected $fillable = [
        'batch_id',
        'day_of_week',
        'start_time',
        'end_time',
        'subject',
        'teacher_name',
        'remarks',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
