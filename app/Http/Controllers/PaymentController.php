<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // 📌 All payments list
public function index()
{
    $payments = Payment::with('student')
        ->latest()
        ->get();

    return response()->json([
        'status' => true,
        'message' => 'Payments fetched successfully',
        'payments' => $payments
    ]);
}
    // 📌 Store new payment
public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'amount' => 'required|numeric',
        'paid_amount' => 'required|numeric',
        'payment_method' => 'nullable|string',
        'payment_date' => 'nullable|date',
        'month' => 'required|string',
    ]);

    $due = $request->amount - $request->paid_amount;

    $status = $due <= 0 ? 'paid' : 'due';

    $payment = Payment::create([
        'student_id' => $request->student_id,
        'amount' => $request->amount,
        'paid_amount' => $request->paid_amount,
        'due_amount' => $due,
        'payment_method' => $request->payment_method,
        'payment_date' => $request->payment_date,
        'month' => $request->month,
        'status' => $status,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Payment created successfully',
        'payment' => $payment
    ]);
}
public function show($id)
{
    $student = Student::with('payments')->find($id);

    if (!$student) {
        return response()->json([
            'message' => 'Student not found'
        ], 404);
    }

    return response()->json([
        'student' => $student
    ]);
}
}
