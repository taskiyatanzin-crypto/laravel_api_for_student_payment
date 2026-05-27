<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PdfController extends Controller
{
   public function whatsappMessage($id)
{
    $payment = Payment::with('student')->findOrFail($id);

    // phone safe format
    $phone = $payment->student->phone ?? null;

    if (!$phone) {
        return response()->json([
            'error' => 'Phone number missing'
        ], 422);
    }

    $phone = preg_replace('/^0/', '88', $phone);

    // receipt URL (same as your PDF endpoint)
    $pdfUrl = url("/api/payments/{$id}/receipt");

    // clean professional message
    $message = "📄 Payment Receipt\n"
        . "---------------------\n"
        . "Receipt ID: {$payment->id}\n"
        . "Name: {$payment->student->full_name}\n"
        . "Class: {$payment->student->batch_name}\n"
        . "Month: {$payment->month}\n"
        . "Paid: ৳{$payment->paid_amount}\n"
        . "Status: {$payment->status}\n\n"
        . "Download Receipt:\n{$pdfUrl}";

    return response()->json([
        'phone' => $phone,
        'message' => $message
    ]);
}
}


