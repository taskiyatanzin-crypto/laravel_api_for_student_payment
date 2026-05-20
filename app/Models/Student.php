<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    //
    use HasApiTokens;

    protected $table = 'students';

    protected $fillable = [
            'full_name',
            'student_id',
            'phone',
            'batch_name',
            'course_name',
            'admission_date',
            'email',
            'month'
    ];
}
