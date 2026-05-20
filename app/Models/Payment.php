<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
        protected $fillable = [
        'student_id',
        'amount',
        'paid_amount',
        'due_amount',
        'payment_method',
        'payment_date',
        'status',
        'month'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
