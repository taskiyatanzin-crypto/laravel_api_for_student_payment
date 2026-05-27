<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PdfController extends Controller
{
    public function downloadReceipt($id)
    {
        try {
            // 1. payment load with student
            $payment = Payment::with('student')->findOrFail($id);

            // 2. generate PDF from blade view
            $pdf = Pdf::loadView('receipt', compact('payment'));

            // 3. create safe file name
            $fileName = 'receipt_' . $payment->id . '.pdf';

            // 4. temp path (Laravel storage temp safe)
            $filePath = storage_path("app/temp_" . $fileName);

            // 5. save PDF temporarily
            file_put_contents($filePath, $pdf->output());

            // 6. upload to cloudinary (safe)
            $uploadedFile = Cloudinary::upload($filePath, [
                'folder' => 'receipts'
            ]);

            $url = $uploadedFile->getSecurePath();

            // 7. update DB (optional safe guard)
            if ($payment) {
                $payment->receipt_url = $url;
                $payment->save();
            }

            // 8. delete temp file safely
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // 9. return response
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
