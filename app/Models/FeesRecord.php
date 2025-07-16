<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesRecord extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'total_fees', 'received_fees', 'balance_fees'];

    public function student()
    {
        return $this->belongsTo(StudentRecord::class, 'student_id');
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
