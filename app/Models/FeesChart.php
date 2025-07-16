<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesChart extends Model
{
    use HasFactory;

    protected $table = 'fees_chart'; // explicitly defining table name if needed

    protected $fillable = [
        'board_exam',
        'std',
        'course_name',
        'subject',
        'yearly_fees',
        'monthly_fees',
        'remarks',
    ];
}
