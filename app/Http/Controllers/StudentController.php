<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */


public function index()
{
    $students = Student::all();

    foreach ($students as $student) {

        $paidMonths = Payment::where('student_id', $student->id)
            ->pluck('month')
            ->toArray();

        $allMonths = [
            'January','February','March','April','May','June',
            'July','August','September','October','November','December'
        ];

        // current month number
        $currentMonth = Carbon::now()->month;

        // January → current month পর্যন্ত
        $monthsTillNow = array_slice($allMonths, 0, $currentMonth);

        // due months
        $dueMonths = array_values(
            array_diff($monthsTillNow, $paidMonths)
        );

        // attach
        $student->setAttribute('due_months', $dueMonths);
    }

    return response()->json([
        'status' => true,
        'students' => $students
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //
        $request -> validate([
            'full_name' => 'required',
            'student_id' => 'required',
            'phone' => 'required',
            'batch_name'     => 'required',
            'course_name'      => 'required',
            'admission_date'     => 'required',
            'email'     => 'required|email|unique:staff,email',
        ]);

       $student = Student::create([
            'full_name' => $request -> full_name,
            'student_id' => $request -> student_id,
            'phone'     => $request -> phone,
            'batch_name'      => $request -> batch_name,
            'course_name'     => $request -> course_name,
            'admission_date'     => $request -> admission_date,
            'email'  =>$request -> email
        ]);

        return response() -> json([
            'status' => true,
            'message' => 'student Created Successfully',
            'student' => $student
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
