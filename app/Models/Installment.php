<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'fees_record_id',
        'installment_no',
        'amount',
        'due_date',
        'receive_date',
        'payment_mode',
        'status',
        'transaction_id',
        'remarks'
    ];

    public function feesRecord()
    {
        return $this->belongsTo(FeesRecord::class);
    }
}
