<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
public function downloadReceipt($id)
{
    $payment = Payment::with('student')->findOrFail($id);

    $pdf = Pdf::loadView('receipt', compact('payment'));

    return response($pdf->output(), 200)
        ->header('Content-Type', 'application/pdf');
}
}
