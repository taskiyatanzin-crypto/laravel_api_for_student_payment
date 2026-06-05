<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
Schema::create('students', function (Blueprint $table) {
    $table->id();

    $table->string('full_name');

    $table->string('student_id')->unique();

    $table->string('phone');
    $table->string('email')->nullable();

    $table->string('course_name')->nullable();
    $table->string('batch_name')->nullable();

    $table->date('admission_date')->nullable();

    $table->enum('status', [
        'active',
        'inactive'
    ])->default('active');

    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }

};
