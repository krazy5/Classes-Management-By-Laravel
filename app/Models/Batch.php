<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

     protected $fillable = [
        'batch_name', 'start_date', 'end_date', 'description',
    ];

    public function students()
    {
        return $this->hasMany(StudentRecord::class, 'batch_id');
    }
}
