<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
     use HasFactory;

   // protected $primaryKey = 'enquiry_id'; // since your PK is not `id`

   protected $fillable = [
        'full_name',
        'contact_number',
        'email',
        'location',
        'course_interested',
        'fees_offered',
        'enquiry_date',
        'status',
        'remark',
    ];
}
