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

    $fileName = 'receipt_' . $id . '.pdf';

    Storage::disk('public')->put('receipts/' . $fileName, $pdf->output());

    return response()->json([
        'status' => true,
        'url' => url("/api/receipt-file/" . $fileName)
    ]);
}
}
