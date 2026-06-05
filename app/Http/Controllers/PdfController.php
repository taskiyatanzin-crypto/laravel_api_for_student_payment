<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function downloadReceipt($id)
    {
        try {

            // 1. Get payment with student relation
            $payment = Payment::with('student')->findOrFail($id);

            // 2. Generate PDF from blade view
            $pdf = Pdf::loadView('receipt', compact('payment'));

            // 3. Define folder inside public storage
            $dir = public_path('receipts');

            // 4. Create folder if not exists
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            // 5. File name
            $fileName = 'receipt_' . $payment->id . '.pdf';

            // 6. Full file path
            $filePath = $dir . '/' . $fileName;

            // 7. Save PDF file
            file_put_contents($filePath, $pdf->output());

            // 8. Public URL (for browser + WhatsApp)
            $url = asset('receipts/' . $fileName);

            return response()->json([
                'success' => true,
                'url' => $url
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Receipt generation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
