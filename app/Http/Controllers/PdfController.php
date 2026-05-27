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

            // 1. payment load
            $payment = Payment::with('student')->findOrFail($id);

            // 2. PDF generate
            $pdf = Pdf::loadView('receipt', compact('payment'));

            // 3. temp folder path
            $tempDir = storage_path('app/temp');

            // folder না থাকলে create করবে
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            // 4. temp file name
            $fileName = 'receipt_' . $payment->id . '.pdf';
            $filePath = $tempDir . '/' . $fileName;

            // 5. save temporary PDF
            file_put_contents($filePath, $pdf->output());

            // 6. upload PDF to Cloudinary
            $uploadedFile = Cloudinary::upload($filePath, [
                'folder' => 'receipts',
                'resource_type' => 'raw', // PDF upload safe
            ]);

            // secure URL
            $url = $uploadedFile->getSecurePath();

            // 7. save URL in DB (optional)
            $payment->receipt_url = $url;
            $payment->save();

            // 8. delete temp file
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // 9. success response
            return response()->json([
                'success' => true,
                'url' => $url
            ]);

        } catch (\Exception $e) {

            // debug error response
            return response()->json([
                'success' => false,
                'message' => 'Receipt generation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
