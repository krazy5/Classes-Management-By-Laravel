<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentRecord;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'student_id',
        'is_read',
    ];

    /**
     * A notification may belong to a student (if it's personal).
     */
    public function student()
    {
        return $this->belongsTo(StudentRecord::class, 'student_id');
    }
}