<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /* =========================
        ALL PAYMENTS LIST
    ========================= */
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

    /* =========================
        STORE PAYMENT
    ========================= */
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

        $payment = Payment::create([
            'student_id' => $request->student_id,
            'amount' => $request->amount,
            'paid_amount' => $request->paid_amount,
            'due_amount' => $due,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'month' => $request->month,
            'status' => $due <= 0 ? 'paid' : 'due',
        ]);

        // relation load
        $payment->load('student');

        return response()->json([
            'status' => true,
            'message' => 'Payment created successfully',
            'payment' => $payment
        ]);
    }

    /* =========================
        SINGLE PAYMENT (MOST IMPORTANT)
    ========================= */
    public function show($id)
    {
        $payment = Payment::with('student')
            ->where('id', $id)
            ->first();

        if (!$payment) {
            return response()->json([
                'status' => false,
                'message' => 'Payment not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'payment' => $payment
        ]);
    }

    /* =========================
        STUDENT PAYMENT HISTORY
    ========================= */
    public function studentPayments($id)
    {
        $payments = Payment::with('student')
            ->where('student_id', $id)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'payments' => $payments
        ]);
    }
}
