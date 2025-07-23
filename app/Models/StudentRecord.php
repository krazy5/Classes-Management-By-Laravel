<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class StudentRecord extends Authenticatable
{
      use Notifiable;
    use HasFactory;

    protected $table = 'student_records'; // Add this line if your table name isn't plural (default)

    // protected $primaryKey = 'student_id'; // Optional: only if student_id is primary key and not auto-incrementing
    // public $incrementing = false; // Optional: because student_id is varchar (UUID)

    protected $fillable = [
        'photo', 'student_id', 'first_name', 'last_name', 'roll_no', 'parent_name', 'dob',
        'mobile_no', 'gender', 'address', 'batch_id', 'start_date', 'class_subject',
        'school_college', 'attachment', 'email', 'std', 'reciept_no'
    ];
    protected $hidden = [
        'password'
    ];
        public function batch()
        {
            return $this->belongsTo(Batch::class, 'batch_id');
        }
        public function attendances()
        {
            return $this->hasMany(Attendance::class);
        }
        public function attachments()
        {
            return $this->hasMany(StudentAttachment::class, 'student_id');
        }
        // In StudentRecord.php
        public function feesRecord()
        {
            return $this->hasOne(FeesRecord::class, 'student_id', 'id');
        }

        // Add this method
        public function sentMessages(): \Illuminate\Database\Eloquent\Relations\MorphMany
        {
            return $this->morphMany(\App\Models\Message::class, 'sender');
        }

        public function receivedMessages(): \Illuminate\Database\Eloquent\Relations\MorphMany
        {
            return $this->morphMany(\App\Models\Message::class, 'recipient');
        }

}
