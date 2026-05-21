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

    // PDF generate
    $pdf = Pdf::loadView('receipt', compact('payment'));

    // file name
    $fileName = 'receipt_' . $id . '.pdf';

    // ✅ এখানে ঠিক এই লাইন বসবে
    Storage::disk('public')->put('receipts/' . $fileName, $pdf->output());

    return response()->json([
        'status' => true,
        'url' => asset('storage/receipts/' . $fileName)
    ]);
}


}
