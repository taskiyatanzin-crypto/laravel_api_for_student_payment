<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    //
     protected $fillable = [
        'full_name',
        'student_id',
        'phone',
        'email',
        'course_name',
        'batch_name',
        'admission_date',
        'status'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
