<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'file_path',
        'file_type',
        'original_name',
    ];

    // Relationship to Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
